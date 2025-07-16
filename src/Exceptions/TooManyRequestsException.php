<?php

/**
 * TooManyRequestsException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 429 Too Many Requests responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class TooManyRequestsException extends Exception
{
    public function __construct(string $message = 'Too Many Requests', ?Throwable $previous = null)
    {
        parent::__construct($message, 429, $previous);
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
