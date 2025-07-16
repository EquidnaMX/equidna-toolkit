<?php

/**
 * NotAcceptableException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Exception for HTTP 406 Not Acceptable responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;

class NotAcceptableException extends Exception
{
    public function __construct(string $message = 'Not Acceptable', int $code = 406)
    {
        parent::__construct($message, $code);
    }

    public function report(): void
    {
        Log::error('NotAcceptableException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::notAcceptable(message: $this->message, errors: ['DEACTIVATED']);
    }
}
