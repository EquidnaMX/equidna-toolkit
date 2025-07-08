<?php

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
        array|Collection $array,
        ?int $page = null,
        ?int $items_per_page = null,
        bool $set_full_url = false
    ): LengthAwarePaginator {


        $array = is_array($array) ? collect($array) : $array;

        $paginator = new LengthAwarePaginator(
            $array->forPage($page, $items_per_page ?: config('hela.pagination_length')),
            $array->count(),
            $items_per_page ?: config('hela.pagination_length'),
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
