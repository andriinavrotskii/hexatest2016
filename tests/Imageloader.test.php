<?php
namespace Andriinavrotskii\Hexatest2016\Tests;

use Andriinavrotskii\Hexatest2016\ImageLoader;
/**
* Tests for ImageLoader
*/
class ImageLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadToPath()
    {

        $path = __DIR__ . DIRECTORY_SEPARATOR . 'images';
        $mime = ['image/jpeg', 'image/png', 'image/gif'];
        $imageLoader = new ImageLoader($path);
        $imageLoader->setAllowMimeTypes($mime);
        $imageLoader->setAllowRewriteFile(true);

        $url = 'http://www.w3schools.com/css/img_fjords.jpg';
        $name = 'my_image';
        $result = $imageLoader->load($url, $name);

        $expectation = [
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR,
            'name' => 'my_image.jpeg',
            'file' => __DIR__ . DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . 'my_image.jpeg'
        ];
        
        $this->assertEquals($result, $expectation);
    }





}