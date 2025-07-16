<?php

/**
 * BadRequestException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 400 Bad Request responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class BadRequestException extends Exception
{
    public function __construct(string $message = 'Bad Request', ?Throwable $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }

    public function report(): void
    {
        Log::error('BadRequestException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::badRequest(message: $this->message, errors: ['DEACTIVATED']);
    }
}
