<?php


namespace NanQi\Hope\Di;


use Psr\Log\LogLevel;

class StdoutLogger extends \Hyperf\Framework\Logger\StdoutLogger
{
    protected function getMessage(string $message, string $level = LogLevel::INFO, array $tags)
    {
        $msg =  parent::getMessage($message, $level, $tags);
        $date = date('Y-m-d H:i:s');
        return  "[{$date}] $msg";
    }
}