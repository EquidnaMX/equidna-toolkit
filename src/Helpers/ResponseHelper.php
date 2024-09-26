<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.0.0
 *
 */

namespace Equidna\Toolkit\Helpers;

use Exception;
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
     * Generates a response for a bad request.
     *
     * This method determines the type of response based on whether the request is an API or hook request.
     * If it is, it returns a 400 response with the provided message. Otherwise, it either redirects back
     * with an error message or to a specified URL with an error message.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if the request is not an API or hook request. Defaults to null.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse A 400 response or a redirect response with an error message.
     */
    public static function badRequest(string $message, string $forward_url = null): Response|RedirectResponse
    {
        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            return response($message, 400);
        }

        if (is_null($forward_url)) {
            return back()->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
    }

    /**
     * Generates a response for an unauthorized request.
     *
     * This method determines the type of response based on whether the request is an API or hook request.
     * If it is, it returns a 401 response with the provided message. Otherwise, it either redirects to the login URL
     * with an error message or to a specified URL with an error message.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if the request is not an API or hook request. Defaults to null.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse A 401 response or a redirect response with an error message.
     */
    public static function unautorized(string $message, string $forward_url = null): Response|RedirectResponse
    {
        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            return response($message, 401);
        }

        if (is_null($forward_url)) {
            return redirect(config('caronte.LOGIN_URL'))->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
    }

    /**
     * Generates a response for a forbidden request.
     *
     * This method determines the type of response based on whether the request is an API or hook request.
     * If it is, it returns a 403 response with the provided message. Otherwise, it either redirects back
     * with an error message or to a specified URL with an error message.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if the request is not an API or hook request. Defaults to null.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse A 403 response or a redirect response with an error message.
     */
    public static function forbidden(string $message, string $forward_url = null): Response|RedirectResponse
    {
        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            return response($message, 403);
        }

        if (is_null($forward_url)) {
            return back()->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
    }

    /**
     * Generates a response for a not found request.
     *
     * This method determines the type of response based on whether the request is an API or hook request.
     * If it is, it returns a 404 response with the provided message. Otherwise, it either redirects back
     * with an error message or to a specified URL with an error message.
     *
     * @param string $message The error message to be included in the response.
     * @param string|null $forward_url The URL to redirect to if the request is not an API or hook request. Defaults to null.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse A 404 response or a redirect response with an error message.
     */
    public static function notFound(string $message, string $forward_url = null): Response|RedirectResponse
    {
        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            return response($message, 404);
        }

        if (is_null($forward_url)) {
            return back()->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
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
    public static function error(string $message, string $forward_url = null): Response|RedirectResponse
    {
        if (RouteHelper::isAPI() || RouteHelper::isHook()) {
            return response($message, 500);
        }

        if (is_null($forward_url)) {
            return back()->withErrors([$message])->withInput();
        }

        return redirect($forward_url)->withErrors([$message])->withInput();
    }

    /**
     * Handles exceptions and returns an appropriate response based on the exception code.
     *
     * @param Exception $exception The exception to handle.
     * @param string|null $forward_url Optional URL to forward to in case of an error.
     * @return Response|RedirectResponse The response corresponding to the exception code.
     */
    public static function handleException(Exception $exception, string $forward_url = null): Response|RedirectResponse
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
            case 500:
                return self::error($exception->getMessage(), $forward_url);
            default:
                return self::error('An unexpected error occurred. (' . $exception->getCode() . '-' . $exception->getMessage() . ')', $forward_url);
        }
    }
}
