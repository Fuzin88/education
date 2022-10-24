<?php

use Fuzin\PhpPro\Convertor\Helpers\SingletonLog;
use GuzzleHttp\Client;
use \PhpPro\Convertor\ {
    UrlConvertor,
    FileRepository
};
use \PhpPro\Convertor\Helpers\UrlValidator;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

require_once  'vendor/autoload.php';

$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'logFile' => [
      'error' => __DIR__ . '/../logs/www/error.log',
      'info' => __DIR__ . '/../logs/www/info.log',
    ],
    'codeLength' => 6,
];


$simpleLogger =  SingletonLog::getInstance(new Logger('general'));
$simpleLogger->pushHandler(new StreamHandler($config['logFile']['error'], Level::Error))
    ->pushHandler(new StreamHandler($config['logFile']['info'], Level::Info));



$fileRepository = new FileRepository($config['dbFile']);
$urlValidator = new UrlValidator(new Client());
$converter = new UrlConvertor(
    $fileRepository,
    $urlValidator,
    $config['codeLength']
);


$url = 'https://www.php.net/manual/ru/';
$codingUrl = $converter->encode($url);
$encodingUrl = $converter->decode($codingUrl);


$a = 1;
