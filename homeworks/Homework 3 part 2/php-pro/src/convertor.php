<?php
use \PhpPro\Convertor\ {
    UrlConvertor,
    FileRepository
};
use \PhpPro\Convertor\Helpers\UrlValidator;


require_once  'autoload.php';

$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'codeLength' => 6,
];

$url = 'https://www.php.net/manual/ru/';

$urlValidator = new UrlValidator();
$converter = new UrlConvertor(new FileRepository($config['dbFile']), $urlValidator, $config['codeLength']);

$codingUrl = $converter->encode($url);
$encodingUrl = $converter->decode($codingUrl);


$a = 1;
