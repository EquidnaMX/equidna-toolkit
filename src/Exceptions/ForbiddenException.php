<?php

/**
 * ForbiddenException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 403 Forbidden responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class ForbiddenException extends Exception
{
    public function __construct(string $message = 'Forbidden', ?Throwable $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }

    public function report(): void
    {
        Log::error('ForbiddenException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::forbidden(message: $this->message, errors: ['DEACTIVATED']);
    }
}
