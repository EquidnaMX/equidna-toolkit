<?php

/**
 * ForbiddenException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.2
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
    /**
     * ForbiddenException constructor.
     *
     * @param string $message Exception message (default: 'Forbidden').
     * @param Throwable|null $previous Previous exception for chaining.
     */
    public function __construct(string $message = 'Forbidden', ?Throwable $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }

    /**
     * Report the exception to the log.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error('ForbiddenException: ' . $this->getMessage(), [
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
        return ResponseHelper::forbidden(message: $this->message);
    }
}
