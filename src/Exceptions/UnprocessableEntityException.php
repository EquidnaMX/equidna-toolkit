<?php

/**
 * UnprocessableEntityException
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.2
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
    /**
     * UnprocessableEntityException constructor.
     *
     * @param string $message Exception message (default: 'Unprocessable Entity').
     * @param Throwable|null $previous Previous exception for chaining.
     */
    public function __construct(string $message = 'Unprocessable Entity', ?Throwable $previous = null)
    {
        parent::__construct($message, 422, $previous);
    }

    /**
     * Report the exception to the log.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error('UnprocessableEntityException: ' . $this->getMessage(), [
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
        return ResponseHelper::unprocessableEntity(message: $this->message);
    }
}
