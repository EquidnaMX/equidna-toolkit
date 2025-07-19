<?php

/**
 * ConflictException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.2
 *
 * Exception for HTTP 409 Conflict responses.
 */

namespace Equidna\Toolkit\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Equidna\Toolkit\Helpers\ResponseHelper;
use Exception;
use Throwable;

class ConflictException extends Exception
{
    /**
     * ConflictException constructor.
     *
     * @param string $message Exception message (default: 'Conflict').
     * @param Throwable|null $previous Previous exception for chaining.
     */
    public function __construct(string $message = 'Conflict', ?Throwable $previous = null)
    {
        parent::__construct($message, 409, $previous);
    }

    /**
     * Report the exception to the log.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error('ConflictException: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ]);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function render(): RedirectResponse|JsonResponse
    {
        return ResponseHelper::conflict(message: $this->message);
    }
}
