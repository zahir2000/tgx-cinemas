<?php

require_once 'LoggerFactory.php';
require_once 'FileLogger.php';

/**
 * Description of FileLoggerFactory
 *
 * @author: Choo Wei Ling
 */
class FileLoggerFactory implements LoggerFactory {

    private string $filePath;

    public function __construct() {
        $this->filePath = $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/WeiLing/Log/tgx-cinemas_' . date("Y-m-d") . '.log';
    }

    public function createLogger(): Logger {
        return new FileLogger($this->filePath);
    }

}
