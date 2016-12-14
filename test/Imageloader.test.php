<?php
namespace Andriinavrotskii\Hexatest2016;

/**
* Tests for ImageLoader
*/
class ImageLoaderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testPing ()
    {
        $imageLoader = new ImageLoader();

        $this->assertEquals('pong', $imageLoader->ping());
    }


}