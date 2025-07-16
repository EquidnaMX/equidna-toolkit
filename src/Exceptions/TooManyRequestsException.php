<?php

/**
 * TooManyRequestsException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Exception for HTTP 429 Too Many Requests responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;

class TooManyRequestsException extends Exception
{
    public function __construct(string $message = 'Too Many Requests', int $code = 429)
    {
        parent::__construct($message, $code);
    }

    public function report(): void
    {
        Log::error('TooManyRequestsException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::tooManyRequests(message: $this->message, errors: ['DEACTIVATED']);
    }
}
