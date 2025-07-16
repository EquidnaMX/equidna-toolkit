<?php

/**
 * ConflictException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Exception for HTTP 409 Conflict responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;

class ConflictException extends Exception
{
    public function __construct(string $message = 'Conflict', int $code = 409)
    {
        parent::__construct($message, $code);
    }

    public function report(): void
    {
        Log::error('ConflictException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::conflict(message: $this->message, errors: ['DEACTIVATED']);
    }
}
