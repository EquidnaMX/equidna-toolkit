<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.0.0
 *
 */

namespace Equidna\Toolkit\Helpers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generates a response based on the context (console, API, hook, or web).
     *
     * @param int $status The HTTP status code of the operation.
     * @param string $message The message to be included in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url The URL to redirect to if applicable. Default is null.
     *
     * @return mixed
     */
    private static function generateResponse(int $status, string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        if (RouteHelper::isConsole()) {
            return $message;
        }

        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            $response = [
                'code'    => $status,
                'message' => $message,
                'errors'  => $errors
            ];

            return response()
                ->json(
                    $response,
                    $status
                );
        }

        if (is_null($forward_url)) {
            return back()->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
    }

    /**
     * Generates a 400 Bad Request response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return mixed The generated response.
     */
    public static function badRequest(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 400,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates a 401 Unauthorized response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url The URL to forward to, if any.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function unautorized(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 401,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates a 403 Forbidden response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function forbidden(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 403,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates a 404 Not Found response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function notFound(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 404,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates a 406 Not acceptable Response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function notAcceptable(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 406,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates a 409 Conflict response.
     *
     * @param string $message The message to include in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function conflict(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 409,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    /**
     * Generates an error response with a 500 status code.
     *
     * @param string $message The error message to be included in the response.
     * @param array $errors An array of errors to include in the response. Default is an empty array.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated error response.
     */
    public static function error(string $message, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 500,
            message: $message,
            errors: $errors,
            forward_url: $forward_url
        );
    }

    public static function success(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 200,
            message: $message,
            errors: [],
            forward_url: $forward_url
        );
    }

    public static function created(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(
            status: 201,
            message: $message,
            errors: [],
            forward_url: $forward_url
        );
    }


    /**
     * Handles exceptions and returns an appropriate response based on the exception code.
     *
     * @param Exception $exception The exception to handle.
     * @param string|null $forward_url Optional URL to forward to in case of an error.
     * @return string|Response|RedirectResponse The response corresponding to the exception code.
     */
    public static function handleException(Exception $exception, array $errors = [], ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        switch ($exception->getCode()) {
            case 400:
                return self::badRequest($exception->getMessage(), $errors, $forward_url);
            case 401:
                return self::unautorized($exception->getMessage(), $errors, $forward_url);
            case 403:
                return self::forbidden($exception->getMessage(), $errors, $forward_url);
            case 404:
                return self::notFound($exception->getMessage(), $errors, $forward_url);
            case 406:
                return self::notAcceptable($exception->getMessage(), $errors, $forward_url);
            case 409:
                return self::conflict($exception->getMessage(), $errors, $forward_url);
            case 500:
                return self::error($exception->getMessage(), $errors, $forward_url);
            default:
                return self::error(
                    message: 'An unexpected error occurred. (' . $exception->getCode() . '-' . $exception->getMessage() . ')',
                    errors: $errors,
                    forward_url: $forward_url
                );
        }
    }
}
