<?php


namespace NanQi\Hope\Overwrite;


class StdoutLogger extends \Hyperf\Framework\Logger\StdoutLogger
{
    public function error($message, array $context = [])
    {
        parent::error($message, $context);
    }
}