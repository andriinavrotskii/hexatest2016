# hexatest2016
Тестовое задание | Middle Developer

Напишите пакет для Composer, который будет загружать картинки с удаленного хоста и
сохранять их на Файловой системе. Пакет должен делать все возможные проверки и бросать
exceptions в случае исключительных ситуаций. Возможные форматы картинок - jpg, png, gif.
Код комментировать, стиль — psr-2
Автолоадер — psr-4
Комменты — phpdoc (опционально)
Юнит-тесты — phpunit (опционально)
Выложить на Github.
Норма времени на выполнение теста - 3 часа.

composer.json
-------------
{
    "require": {
        "andriinavrotskii/hexatest2016": "dev-master"
    }
}



Simple usage
------------

$url = 'http://some_valid_url/image.jpg';
$imageLoader = new ImageLoader();
$result = $imageLoader->load($url);

If all is OK - image will be saved in php tmp directory.

$result:
Array
(
    [path] => /tmp/
    [name] => 269497fd3602fb3a1c7c936c5493a7b2.jpeg
    [file] => /tmp/269497fd3602fb3a1c7c936c5493a7b2.jpeg
)



Advanced usage
-------------- 

$path = __DIR__ . 'some/path';
$mime = ['image/jpeg', 'image/png', 'image/gif'];

$imageLoader = new ImageLoader($path);
$imageLoader->setAllowMimeTypes($mime);
$imageLoader->setAllowRewriteFile(false);


$url = 'http://some_valid_url/image.gif';
$name = 'my_image';
$result = $imageLoader->load($url, $name);

$result:
Array
(
    [path] => __DIR__ . '/some/path/'
    [name] => 'my_image.gif'
    [file] => __DIR__ . '/some/path/my_image.gif'
)




$url = 'http://some_valid_url/image.jpg';
$result = $imageLoader->load($url);

$result:
Array
(
    [path] => __DIR__ . '/some/path/'
    [name] => 597457a73957b1c4513ce0c2b1374cf1.jpeg
    [file] => __DIR__ . '/some/path/597457a73957b1c4513ce0c2b1374cf1.jpeg'
)
