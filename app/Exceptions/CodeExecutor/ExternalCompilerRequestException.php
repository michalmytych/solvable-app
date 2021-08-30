<?php


namespace App\Exceptions\CodeExecutor;

use Exception;
use Illuminate\Support\Facades\Log;

class ExternalCompilerRequestException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error(
            'Error when requesting external compiler service at ' . now(),
            [
                'message_from_external' => $this->message,
                'status_code_from_external' => $this->code,
            ]
        );
    }
}
