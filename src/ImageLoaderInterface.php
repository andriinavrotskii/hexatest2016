<?php
namespace Andriinavrotskii\Hexatest2016;


interface ImageLoaderInterface
{
	public function load(string $url,string  $fileName = '');

	public function setSaveToPath(string $path = '');

	public function getSaveToPath();

	public function setAllowMimeTypes(array $allowMimeTypes = []);

	public function getAllowMimeTypes();

	public function setAllowRewriteFile(bool $allowRewriteFile = true);
	
	public function getAllowRewriteFile();
}
