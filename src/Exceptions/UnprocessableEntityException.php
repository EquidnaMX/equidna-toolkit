<?php

/**
 * UnprocessableEntityException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Exception for HTTP 422 Unprocessable Entity responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;

class UnprocessableEntityException extends Exception
{
    public function __construct(string $message = 'Unprocessable Entity', int $code = 422)
    {
        parent::__construct($message, $code);
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
