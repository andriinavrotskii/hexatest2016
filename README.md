# hexatest2016
Test for Hexa 


Simple usage
------------

$url = 'http://some_valid_url/image.jpg';
$imageLoader = new ImageLoader();
$result = $imageLoader->load($url);

If all is OK - image will ba saved in php tmp directory.

$result:
Array
(
    [path] => /tmp/
    [name] => 269497fd3602fb3a1c7c936c5493a7b2.jpeg
    [file] => /tmp/269497fd3602fb3a1c7c936c5493a7b2.jpeg
)



Advanced usage
-------------- 

$path = 'some/path';
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
    [path] => /some/path/
    [name] => my_image.gif
    [file] => /some/path/my_image.gif
)


$url = 'http://some_valid_url/image.png';
$name = 'my_next_image';
$result = $imageLoader->load($url, $name);

$result:
Array
(
    [path] => /some/path/
    [name] => my_next_image.png
    [file] => /some/path/my_next_image.png
)

$url = 'http://some_valid_url/image.jpg';
$result = $imageLoader->load($url);

$result:
Array
(
    [path] => /some/path/
    [name] => 597457a73957b1c4513ce0c2b1374cf1.jpeg
    [file] => /some/path/597457a73957b1c4513ce0c2b1374cf1.jpeg
)
