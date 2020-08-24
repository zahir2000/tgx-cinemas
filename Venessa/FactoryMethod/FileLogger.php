<?php

require_once 'Logger.php';

/**
 * Description of FileLogger
 *
 * @author: Venessa Choo Wei Ling
 */
class FileLogger implements Logger {

    private string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    public function log(string $message) {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        file_put_contents($this->filePath, date('d-m-Y H:i:s') . " -> " . $message . PHP_EOL, FILE_APPEND);
    }

}
