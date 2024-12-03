<?php

/**
 * @author Erick Escobar
 * @license MIT
 * @version 1.0.0
 *
 */

namespace Equidna\Toolkit\Traits\Database;

use Equidna\Toolkit\Helpers\RouteHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

trait Paginator
{
    /**
     * Scope a query for pagination with optional transformation.
     *
     * @param Builder $query The query builder instance.
     * @param string $pageName The name of the pagination parameter. Default is 'page'.
     * @param int $page The current page number. Default is 1.
     * @param int|null $page_items The number of items per page. Default is null, which uses the configuration value.
     * @param callable|null $transformation An optional transformation callback to apply to the paginator items.
     *
     * @return LengthAwarePaginator|array The paginated result, either as a LengthAwarePaginator instance or an array if the request is an API call.
     */
    public function scopePaginator(
        Builder $query,
        string $pageName = 'page',
        null|int $page = 1,
        null|int $perPage = null,
        null|callable $transformation = null
    ): LengthAwarePaginator|array {

        $perPage = $perPage ?? config('equidna.paginator.page_items');

        $paginator = $query->paginate(
            $perPage,
            ['*'],
            $pageName,
            $page ?? config('apollo.page')
        );

        if (!is_null($transformation)) {
            # used tap to apply the transformation to the paginator items
            # preventing a linter error when using the paginator directly

            tap($paginator, fn(LengthAwarePaginator $paginator) => $paginator->through($transformation));
        }

        if (RouteHelper::isAPI()) {
            return [
                'data' => $paginator->items(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ];
        }

        return $paginator;
    }
}
