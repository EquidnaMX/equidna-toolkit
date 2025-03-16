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
     * @param int $error_code The error code to be used in the response.
     * @param string $message The message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if applicable. Default is null.
     *
     * @return string|Response|RedirectResponse The generated response, which could be a string, a Response object, or a RedirectResponse object.
     */
    private static function generateResponse(int $status, string $message, ?string $forward_url)
    {
        if (RouteHelper::isConsole()) {
            return $message;
        }

        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            $response = [
                'message' => $message,
                'code'    => $status
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
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function badRequest(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(400, $message, $forward_url);
    }

    /**
     * Generates a 401 Unauthorized response.
     *
     * @param string $message The message to include in the response.
     * @param string|null $forward_url The URL to forward to, if any.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function unautorized(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(401, $message, $forward_url);
    }

    /**
     * Generates a 403 Forbidden response.
     *
     * @param string $message The message to include in the response.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function forbidden(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(403, $message, $forward_url);
    }

    /**
     * Generates a 404 Not Found response.
     *
     * @param string $message The message to include in the response.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function notFound(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(404, $message, $forward_url);
    }

    /**
     * Generates a 409 Conflict response.
     *
     * @param string $message The message to include in the response.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated response.
     */
    public static function conflict(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(409, $message, $forward_url);
    }

    /**
     * Generates a response for an internal server error.
     *
     * This method determines the type of response based on whether the request is an API or hook request.
     * If it is, it returns a 500 response with the provided message. Otherwise, it either redirects back
     * with an error message or to a specified URL with an error message.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if the request is not an API or hook request. Defaults to null.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse A 500 response or a redirect response with an error message.
     */

    /**
     * Generates an error response with a 500 status code.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url Optional URL to redirect to.
     * @return string|Response|RedirectResponse The generated error response.
     */
    public static function error(string $message, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        return self::generateResponse(500, $message, $forward_url);
    }

    /**
     * Handles exceptions and returns an appropriate response based on the exception code.
     *
     * @param Exception $exception The exception to handle.
     * @param string|null $forward_url Optional URL to forward to in case of an error.
     * @return string|Response|RedirectResponse The response corresponding to the exception code.
     */
    public static function handleException(Exception $exception, ?string $forward_url = null): string|JsonResponse|RedirectResponse
    {
        switch ($exception->getCode()) {
            case 400:
                return self::badRequest($exception->getMessage(), $forward_url);
            case 401:
                return self::unautorized($exception->getMessage(), $forward_url);
            case 403:
                return self::forbidden($exception->getMessage(), $forward_url);
            case 404:
                return self::notFound($exception->getMessage(), $forward_url);
            case 409:
                return self::conflict($exception->getMessage(), $forward_url);
            case 500:
                return self::error($exception->getMessage(), $forward_url);
            default:
                return self::error('An unexpected error occurred. (' . $exception->getCode() . '-' . $exception->getMessage() . ')', $forward_url);
        }
    }
}
