<?php
namespace Andriinavrotskii\Hexatest2016;

use Exception;

/**
* Load image from url. 
* Return array with filename, directory, and path loaded file. Or false if fail.
*/
class ImageLoader implements ImageLoaderInterface
{
    /**
     * Directory where image will be saved
     *
     * @var string
     */
    private $saveToPath;

    /**
     * Allowed mime file types
     *
     * @var array
     */
    private $allowMimeTypes;

    /**
     * Rewrite existing file. true - allow rewrite, false - disallow
     *
     * @var bool
     */
    private $allowRewriteFile;

    /**
     * Construct method
     *
     * @param string $saveToPath (optional)
     */
    public function __construct(string $saveToPath = '')
    {
        $this->setSaveToPath($saveToPath);
        $this->setAllowMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
        $this->setAllowRewriteFile(true);
    }

    /**
     * Main method - loading image
     *
     * @param string $url
     * @param string $fileName (optional)
     *
     * @return array Return array if success
     *
     * @throws Exception
     */
    public function load(string $url,string  $fileName = '')
    {
        $this->checkBeforeLoading($url);

        $curlChannel = curl_init($url);
        curl_setopt($curlChannel, CURLOPT_HEADER, 0);
        curl_setopt($curlChannel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlChannel, CURLOPT_BINARYTRANSFER, 1);

        $raw = curl_exec($curlChannel);
        
        $curlMimeType = curl_getinfo($curlChannel, CURLINFO_CONTENT_TYPE);

        $this->checkAllowMimeTypes($curlMimeType);

        curl_close ($curlChannel);

        $saveTo = $this->getSaveTo($fileName, $curlMimeType);

        $this->checkSaveToFile($saveTo['file']);

        if (file_put_contents($saveTo['file'], $raw)) {
            return $saveTo;
        } else {
            throw new Exception("Image not saved");
        }
    }

    /**
     * Set path for images, if $path is empty - set php temp dir
     *
     * @param string $path (optional)
     * 
     * @return void
     *
     * @throws Exception
     */
    public function setSaveToPath(string $path = '')
    {
        if (empty($path)) {
            $path = sys_get_temp_dir();
        }

        if (substr($path, -1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }

        if (is_dir($path)) {
            $this->saveToPath = $path;
        } else {
            throw new Exception("Path not exist - " . $path);
        }
    }

    /**
     * Get directory for images
     * 
     * @return string
     */
    public function getSaveToPath()
    {
        return $this->saveToPath;
    }


    /**
     * Set array of allowed mime types
     *
     * @param array $allowMimeTypes (optional)
     * 
     * @return void
     *
     * @throws Exception
     */
    public function setAllowMimeTypes(array $allowMimeTypes = []) 
    {
        if (empty($allowMimeTypes)) {
            throw new Exception("Expect at least one mime type");
        }

        $this->allowMimeTypes = $allowMimeTypes;
    }

    /**
     * Get allowed mime types
     * 
     * @return string
     */
    public function getAllowMimeTypes()
    {
        return $this->allowMimeTypes;
    }

    /**
     * Set enable or disable rewrite file if file with same name is exist
     *
     * @param bool $allowRewriteFile (optional)
     * 
     * @return void
     */
    public function setAllowRewriteFile(bool $allowRewriteFile = true)
    {
        $this->allowRewriteFile = $allowRewriteFile;
    }

    /**
     * Get allowRewriteFile
     * 
     * @return void
     */
    public function getAllowRewriteFile()
    {
        return $this->allowRewriteFile;
    }


    /**
     * Check image before loading. Check headers and image size
     *
     * @param string $url
     *
     * @return void 
     *
     * @throws Exception
     */
    private function checkBeforeLoading(string $url)
    {
        // check headers
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Url is not valid!");
        }

        $headers = get_headers ($url);
        $responseCode = substr($headers[0], 9, 3);
        if ($responseCode != '200') {
            throw new Exception("Response code - " . $responseCode);
        }

        // check image size
        if ($imageSize = @getimagesize($url)) {

            if ($imageSize['0'] < 1 && $imageSize['1'] < 1) {
                throw new Exception("Image with zero size - " . $imageSize['3']);
            }

            $this->checkAllowMimeTypes($imageSize['mime']);

        } else {
            throw new Exception("File is not a image!");
        }
    }


    /**
     * Check if mime type in array of allowed mime types
     * 
     * @param string $mimeType
     *
     * @return void
     *
     * @throws Exception
     */
    private function checkAllowMimeTypes(string $mimeType)
    {
        if (!in_array ($mimeType, $this->allowMimeTypes)) {
            throw new Exception("Not allowed mime type - " . $mimeType);
        }

    }


    /**
     * Generate array of path, name, full file path
     *
     * @param string $fileName
     * @param string $mimeType
     *
     * @return array
     */
    private function getSaveTo(string $fileName, string $mimeType)
    {
        $mimeTypeArr = explode('/', $mimeType);
        $extension = '.' . $mimeTypeArr[1];

        if (empty($fileName)) {
            $name = md5(microtime()) . $extension;
        } else {
            $name = $fileName . $extension;
        }

        $saveTo = [
            'path' => $this->saveToPath,
            'name' => $name,
            'file' => $this->saveToPath . $name
        ];

        return $saveTo;
    }

    /**
     * Check file now exist or not and allowed rewrite file or not/
     *
     * @param string $file
     *
     * @return void
     *
     * @throws Exception
     */
    private function checkSaveToFile(string $file)
    {
        if (!file_exists($file) || (file_exists($file) && $this->allowRewriteFile)) {
            return;
        }

        throw new Exception("File is exist. Rewrite not allowed.");
    }
}
