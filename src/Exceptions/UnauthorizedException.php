<?php

/**
 * UnauthorizedException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 401 Unauthorized responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class UnauthorizedException extends Exception
{
    public function __construct(string $message = 'Unauthorized', ?Throwable $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }

    public function report(): void
    {
        Log::error('UnauthorizedException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::unauthorized(message: $this->message, errors: ['DEACTIVATED']);
    }
}
