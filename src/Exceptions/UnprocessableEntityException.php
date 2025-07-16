<?php

/**
 * UnprocessableEntityException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.1
 *
 * Exception for HTTP 422 Unprocessable Entity responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class UnprocessableEntityException extends Exception
{
    public function __construct(string $message = 'Unprocessable Entity', ?Throwable $previous = null)
    {
        parent::__construct($message, 422, $previous);
    }

    public function report(): void
    {
        Log::error('UnprocessableEntityException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::unprocessableEntity(message: $this->message, errors: ['DEACTIVATED']);
    }
}
