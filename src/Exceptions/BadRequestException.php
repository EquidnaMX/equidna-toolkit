<?php

/**
 * BadRequestException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Exception for HTTP 400 Bad Request responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;

class BadRequestException extends Exception
{
    public function __construct(string $message = 'Bad Request', int $code = 400)
    {
        parent::__construct($message, $code);
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
