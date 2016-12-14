<?php
namespace Andriinavrotskii\Hexatest2016;

use Exception;

/**
* 
*/
class ImageLoader
{

    private $saveToPath;
    private $allowMimeTypes;
    private $allowRewriteFile;

    
    function __construct(string $saveToPath = '')
    {
        $this->setSaveToPath($saveToPath);
        $this->setAllowMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
        $this->setAllowRewriteFile(true);
    }

    /**
     * 
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


    public function getSaveToPath()
    {
        return $this->saveToPath;
    }


    public function setAllowMimeTypes(array $allowMimeTypes = []) {
        if (empty($allowMimeTypes)) {
            throw new Exception("Expect at least one mime type");
            return;
        }

        $this->allowMimeTypes = $allowMimeTypes;
    }

    public function getAllowMimeTypes()
    {
        return $this->allowMimeTypes;
    }


    public function setAllowRewriteFile(bool $allowRewriteFile)
    {
        $this->allowRewriteFile = $allowRewriteFile;
    }

    public function getAllowRewriteFile()
    {
        return $this->allowRewriteFile;
    }


    /**
     *
     */
    public function load($url, $fileName = '')
    {
        if ($this->checkBeforeLoading($url) === false) {
            return;
        }

        $curlChannel = curl_init($url);
        curl_setopt($curlChannel, CURLOPT_HEADER, 0);
        curl_setopt($curlChannel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlChannel, CURLOPT_BINARYTRANSFER, 1);

        $raw = curl_exec($curlChannel);
        
        $curlMimeType = curl_getinfo($curlChannel, CURLINFO_CONTENT_TYPE);
        if (!$this->checkAllowMimeTypes($curlMimeType)) {
            throw new Exception("Not allowed mime type - " . $imageSize['mime']);
            return false;
        }

        curl_close ($curlChannel);

        $saveTo = $this->getSaveTo($fileName, $curlMimeType);

        if ($this->checkSaveToFile($saveTo['file']) && file_put_contents($saveTo['file'], $raw)) {
            return $saveTo;
        } else {
            return false;
        }
    }



    private function checkBeforeLoading(string $url)
    {
        // check headers
        $headers = get_headers ($url);
        if (substr($headers[0], 9, 3) != '200') {
            throw new Exception("Response code - " . $headers[0]);
            return false;
        }

        // check image size
        if ($imageSize = @getimagesize($url)) {

            if ($imageSize['0'] < 1 && $imageSize['1'] < 1) {
                throw new Exception("Image whith zero size - " . $imageSize['3']);
                return false;
            }

            if (!$this->checkAllowMimeTypes($imageSize['mime'])) {
                throw new Exception("Not allowed mime type - " . $imageSize['mime']);
                return false;
            }

        } else {
            throw new Exception("File is not a image!");
            return false;
        }

        return true;
    }


    private function checkAllowMimeTypes(string $mimeType)
    {
        return in_array ($mimeType, $this->allowMimeTypes);
    }


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


    private function checkSaveToFile(string $file)
    {
        if (!file_exists($file)) {
            return true;
        } elseif (file_exists($file) && $this->allowRewriteFile) {
            return true;
        }

        return false;
    }
}

