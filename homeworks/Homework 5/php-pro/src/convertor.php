<?php
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

$logger = new Logger('general');
$logger->pushHandler(new StreamHandler($config['logFile']['error'], Level::Error));
$logger->pushHandler(new StreamHandler($config['logFile']['info'], Level::Info));

$logger->error('111');
$logger->info('222');


$fileRepository = new FileRepository($config['dbFile']);
$urlValidator = new UrlValidator();
$converter = new UrlConvertor(
    $fileRepository,
    $urlValidator,
    $logger,
    $config['codeLength']
);


$url = 'https://www.php.net/manual/ru/';
$codingUrl = $converter->encode($url);
$encodingUrl = $converter->decode($codingUrl);


$a = 1;
