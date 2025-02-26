<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

trait ExceptionTrait
{
    /**
     * @param Throwable $exception
     * @return void
     */
    function logException(Throwable $exception): void
    {
        Log::error('File: ' . $exception->getFile() . ', Line: ' . $exception->getLine() . ', Message: ' . $exception->getMessage());
    }
}
