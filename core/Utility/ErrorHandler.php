<?php

namespace core\Utility;

class ErrorHandler
{
    public static function errorHandler($level, $mes, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($mes, 0, $level, $file, $line);
        }
    }

    public static function exceptionHandler($e)
    {
        //
    }
}