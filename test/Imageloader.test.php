<?php
namespace Andriinavrotskii\Hexatest2016;

/**
* Tests for ImageLoader
*/
class ImageLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $url = 'http://trek.scene7.com/is/image/TrekBicycleProducts/2130600_2017_A_2_TOP_FUEL_9_8_SL?wid=1200&hei=1200&fit=fit,1&fmt=png-alpha&op_usm=0,0,0,0&iccEmbed=0&extend=24,324,144,188';

        $imageLoader = new ImageLoader();
        $result = $imageLoader->load($url, 'bike');

        $expectation = [
            'path' => '/tmp/',
            'name' => 'bike.png',
            'file' => '/tmp/bike.png'
        ];
        
        $this->assertEquals($result, $expectation);
    }


    /**
     * @expectedException        Exception
     * @expectedExceptionMessage File is not a image!
     */
    public function testFileIsNotImage()
    {
        $url = 'https://www.google.com.ua/';

        $imageLoader = new ImageLoader();
        $imageLoader->load($url);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Not allowed mime type - image/x-ms-bmp
     */
    public function testAllowedMimeType()
    {
        $url = 'http://www.ece.rice.edu/~wakin/images/lena512.bmp';

        $imageLoader = new ImageLoader();
        $imageLoader->load($url);
    }



    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Url is not valid!
     */
    public function testValidUrl()
    {
        $url = 'asdasdasd';

        $imageLoader = new ImageLoader();
        $imageLoader->load($url);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Response code - 404
     */
    public function testCode404()
    {
        $url = 'http://www.ece.rice.edu/blablabla.bmp';

        $imageLoader = new ImageLoader();
        $imageLoader->load($url);
    }


    public function testSaveToPath()
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setSaveToPath('src');
        $this->assertEquals($imageLoader->getSaveToPath(), 'src/');
    }


    public function testAllowMimeTypes()
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setAllowMimeTypes(['image/jpeg']);
        $this->assertEquals($imageLoader->getAllowMimeTypes(), ['image/jpeg']);
    }

    /**
     * @expectedException File is exist. Rewrite not allowed.
     */
    public function testAllowRewriteFile()
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setAllowRewriteFile(false);
        $this->assertFalse($imageLoader->getAllowRewriteFile());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage File is exist. Rewrite not allowed.
     */
    public function testRewriteFile()
    {
        $url = 'http://trek.scene7.com/is/image/TrekBicycleProducts/2130600_2017_A_2_TOP_FUEL_9_8_SL?wid=1200&hei=1200&fit=fit,1&fmt=png-alpha&op_usm=0,0,0,0&iccEmbed=0&extend=24,324,144,188';

        $imageLoader = new ImageLoader();
        $imageLoader->setAllowRewriteFile(false);
        $result = $imageLoader->load($url, 'bike');
    }


}