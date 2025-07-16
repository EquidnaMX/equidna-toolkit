<?php

/**
 * NotFoundException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 404 Not Found responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $message = 'Not Found', ?Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }

    public function report(): void
    {
        Log::error('NotFoundException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::notFound(message: $this->message, errors: ['DEACTIVATED']);
    }
}
