<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.0.0
 *
 */

namespace Equidna\Toolkit\Helpers;

class RouteHelper
{
    private function __construct()
    {
        //
    }

    public static function isWeb(): bool
    {
        return !self::isAPI()
            && !self::isHook()
            && !self::isIoT()
            && !self::isConsole();
    }

    /**
     * Determine if the request is an API request.
     *
     * @return bool
     */
    public static function isAPI(): bool
    {
        return request()->is('api/*');
    }

    /**
     * Determine if the request is a hook request.
     *
     * @return bool
     */
    public static function isHook(): bool
    {
        return request()->is('hooks/*');
    }

    /**
     * Determine if the request is an IoT request.
     *
     * @return bool
     */
    public static function isIoT(): bool
    {
        return request()->is('iot/*');
    }

    /**
     * Determines if the given string is a valid expression.
     *
     * @param string $expression The string to evaluate.
     * @return bool Returns true if the string is a valid expression, false otherwise.
     */
    public function isExpression(string $expression): bool
    {
        return request()->is($expression);
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool True if the application is running in the console, false otherwise.
     */
    public static function isConsole(): bool
    {
        return app()->runningInConsole();
    }
}
