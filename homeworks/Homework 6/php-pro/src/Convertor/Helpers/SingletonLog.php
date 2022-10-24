<?php

namespace Fuzin\PhpPro\Convertor\Helpers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class SingletonLog
{

    protected static  $instance;
    protected LoggerInterface $logger;

    public static function getInstance(LoggerInterface $logger = null): LoggerInterface
    {
        if(!self::$instance) {
            if(is_null($logger)) {
                throw new \InvalidArgumentException('Logger is undefined');
            }
            self::$instance = new static($logger);
        }

        return self::$instance->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    protected function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

    }

    public function pushHandler(AbstractProcessingHandler $handler): self
    {
        $this->logger->pushHandler($handler);
        return $this;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    protected function __clone() {}
    protected function __wakeup(){}



}