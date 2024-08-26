<?php

namespace Common;

class Log
{
    const string LOG_DIR = '/var/www/';

    const string LOG_TYPE_SEARCH_POST = 'search_log';

    protected string $logType;

    public function __construct(string $logType)
    {
        if (!file_exists(self::LOG_DIR)) {
            mkdir(self::LOG_DIR, 0777, true);
        }

        $this->logType = $logType;
    }

    /**
     * @param string $message
     * @return void
     */
    public static function save(string $message): void
    {
        $file = fopen(self::LOG_DIR . self::LOG_TYPE_SEARCH_POST . '.txt', 'a+');
        fwrite($file, $message . "\n");
    }
}