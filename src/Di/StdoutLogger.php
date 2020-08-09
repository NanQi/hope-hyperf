<?php


namespace NanQi\Hope\Di;


class StdoutLogger extends \Hyperf\Framework\Logger\StdoutLogger
{
    public function error($message, array $context = [])
    {
        parent::error($message, $context);
    }
}