<?php

/**
 * PaginatorHelper
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.0
 *
 * Provides static utility methods for pagination.
 * This helper class is designed to assist with paginating data
 * and generating pagination-related information.
 */

namespace Equidna\Toolkit\Helpers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PaginatorHelper
{
    public const EXCLUDE_FROM_REQUEST = [
        '_token',
        'page',
        'client_user',
        'client_token',
        'client_token_type'
    ];

    public static function buildPaginator(
        array|Collection $data,
        ?int $page = null,
        ?int $items_per_page = null,
        bool $set_full_url = false
    ): LengthAwarePaginator {

        $data = is_array($data) ? collect($data) : $data;

        $paginationLength = $items_per_page ?: config('equidna.paginator.page_items');

        $paginator = new LengthAwarePaginator(
            $data->forPage($page, $paginationLength),
            $data->count(),
            $paginationLength,
            $page ?: 1
        );

        if ($set_full_url) {
            static::setFullURL($paginator);
        }

        return $paginator;
    }

    public static function appendCleanedRequest(LengthAwarePaginator $paginator, Request $request): void
    {
        $paginator->appends($request->except(static::EXCLUDE_FROM_REQUEST));
    }

    public static function setFullURL(LengthAwarePaginator $paginator): void
    {
        $paginator->setPath(url()->current());
    }
}
