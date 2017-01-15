<?php
namespace Andriinavrotskii\Hexatest2016\Tests;

use Andriinavrotskii\Hexatest2016\ImageLoader;
use Andriinavrotskii\Hexatest2016\Tests\PrivateTestTrait;
/**
* Tests for ImageLoader
*/
class ImageLoaderPrivateTest extends \PHPUnit_Framework_TestCase
{
    use PrivateTestTrait;



    public function testGetRewriteFile()
    {
        $imageLoader = new ImageLoader();
        $allowRewriteFileFromGet = $imageLoader->getAllowRewriteFile();
        $allowRewriteFileFromProperty = $this->getPropertyValue($imageLoader, 'allowRewriteFile');

        $this->assertEquals($allowRewriteFileFromGet, $allowRewriteFileFromProperty);

    }


    /**
     * @dataProvider testSetAllowRewriteFile
     */
    public function providerTestSetAllowRewriteFile()
    {
        return [
            [true, true],
            [false, false]
        ];
    }

    /**
     * @param string $original 
     * @param string $expected 
     *
     * @dataProvider providerTestSetAllowRewriteFile
     */
    public function testSetAllowRewriteFile($original, $expected)
    {
        $imageLoader = new ImageLoader();

        $imageLoader->setAllowRewriteFile($original);
        $allowRewriteFile = $this->getPropertyValue($imageLoader, 'allowRewriteFile');

        $this->assertEquals($expected, $allowRewriteFile);
    }






    public function testGetAllowMimeTypes()
    {
        $imageLoader = new ImageLoader();
        $allowMimeTypesFromGet = $imageLoader->getAllowMimeTypes();
        $allowMimeTypesFromProperty = $this->getPropertyValue($imageLoader, 'allowMimeTypes');

        $this->assertEquals($allowMimeTypesFromProperty, $allowMimeTypesFromGet);

    }


    public function testPropertyAllowMimeTypes()
    {
        $imageLoader = new ImageLoader();
        $allowMimeTypes = $this->getPropertyValue($imageLoader, 'allowMimeTypes');

        $this->assertEquals(['image/jpeg', 'image/png', 'image/gif'], $allowMimeTypes);

    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Expect at least one mime type
     */
    public function testSetAllowMimeTypesException()
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setAllowMimeTypes();
    }


    /**
     * @dataProvider testSetAllowMimeTypes
     */
    public function providerTestSetAllowMimeTypes()
    {
        return [
            [['image/jpeg'], ['image/jpeg']],
            [['image/png', 'image/gif'], ['image/png', 'image/gif']],
            [['image/png', 'image/tiff'], ['image/png', 'image/tiff']]
        ];
    }

    /**
     * @param string $original 
     * @param string $expected 
     *
     * @dataProvider providerTestSetAllowMimeTypes
     */
    public function testSetAllowMimeTypes($original, $expected)
    {
        $imageLoader = new ImageLoader();

        $imageLoader->setAllowMimeTypes($original);
        $allowMimeTypes = $this->getPropertyValue($imageLoader, 'allowMimeTypes');

        $this->assertEquals($expected, $allowMimeTypes);
    }



    public function testGetSaveToPath()
    {
        $imageLoader = new ImageLoader();
        $saveToPathFromGet = $imageLoader->getSaveToPath();

        $saveToPathFromPropery = $this->getPropertyValue($imageLoader, 'saveToPath');

        $this->assertEquals($saveToPathFromPropery, $saveToPathFromGet);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Path not exist - fake/dir/
     */
    public function testSetSaveToPathException()
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setSaveToPath('fake/dir/');
    }


    /**
     * @dataProvider testSetSaveToPath
     */
    public function providerTestSetSaveToPath()
    {
        return [
            ['', '/tmp/'],
            [__DIR__ . '/images', __DIR__ . '/images/'],
            [__DIR__ . '/images/', __DIR__ . '/images/']
        ];
    }


    /**
     * @param string $original 
     * @param string $expected 
     *
     * @dataProvider providerTestSetSaveToPath
     */
    public function testSetSaveToPath($original, $expected)
    {
        $imageLoader = new ImageLoader();
        $imageLoader->setSaveToPath($original);
        $saveToPath = $this->getPropertyValue($imageLoader, 'saveToPath');

        $this->assertEquals($expected, $saveToPath);

    }



}
