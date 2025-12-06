<?php

namespace App\Class\Common;

use App\Constants\Messages;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiCatchErrors
{
    /**
     *
     * Summary: Rollback db transaction failure something
     *
     * @param Exception|null $exception
     * @param string $message
     * @return void
     */
    public static function rollback(Exception $exception = null,
                                    string    $message = Messages::GENERAL_RESPONSE_ERROR_MESSAGE): void
    {
        DB::rollBack();

        self::throw($exception, $message);
    }

    /**
     *
     * Summary: Throw error log
     *
     * @param Exception|null $exception
     * @param string $message
     * @return void
     */
    public static function throw(Exception $exception = null,
                                 string    $message = Messages::GENERAL_RESPONSE_ERROR_MESSAGE): void
    {
        Log::error(
            $message .
            '(File: ' . $exception->getFile() .
            ' (Line: ' . $exception->getLine() . ')' .
            ' Error message: ' . $exception->getMessage()
        );
    }
}
