# Equidna Toolkit v0.6.3

---

Equidna Toolkit is a Laravel package (v0.6.2) providing Helpers, Traits, Middleware, and Service Providers to streamline modular application development. Now supports Laravel 11 and 12.

---

## Middleware

### ExcludeFromHistory

**Namespace:** `Equidna\Toolkit\Http\Middleware`

Prevents the current request from being stored in the session as the current URL.

---

## Traits

### HasCompositePrimaryKey

**Namespace:** `Equidna\\Toolkit\\Traits\\Database`

Enables Eloquent models to support composite primary keys.
**Usage Example:**

```php
class MyModel extends Model {
    use HasCompositePrimaryKey;
    public function getKeyName() { return ['key1', 'key2']; }
}
```

---

## Helpers

### RouteHelper

**Namespace:** `Equidna\Toolkit\Helpers`

Static methods for request type detection:

```php
RouteHelper::isWeb()
RouteHelper::isApi()
RouteHelper::isHook()
RouteHelper::isIoT()
RouteHelper::isExpression(string $expression)
RouteHelper::isConsole()
RouteHelper::wantsJson()
RouteHelper::getMethod()
RouteHelper::isMethod(string $method)
RouteHelper::getRouteName()
RouteHelper::isRouteName(string $name)
RouteHelper::routeContains(string $name)
```

---

### ResponseHelper

**Namespace:** `Equidna\Toolkit\Helpers`

Static methods for generating error and success responses.
Returns a `RedirectResponse` for web requests or a JSON response for API requests.

**Error Responses:**

```php
ResponseHelper::badRequest(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::unauthorized(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::forbidden(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::notFound(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::notAcceptable(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::conflict(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::unprocessableEntity(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::tooManyRequests(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::error(string $message, array $errors = [], array $headers = [], string $forward_url = null)
ResponseHelper::handleException(Exception $exception, array $errors = [], array $headers = [], string $forward_url = null)
```

**Success Responses:**

```php
ResponseHelper::success(string $message, mixed $data = null, string $forward_url = null)
ResponseHelper::created(string $message, mixed $data = null, string $forward_url = null)
ResponseHelper::accepted(string $message, mixed $data = null, string $forward_url = null)
ResponseHelper::noContent(string $message = 'Operation completed successfully', string $forward_url = null)
```

---

### PaginatorHelper

**Namespace:** `Equidna\Toolkit\Helpers`

Builds paginated responses from arrays or collections, using config-driven pagination length.

```php
PaginatorHelper::buildPaginator(array|Collection $data, ?int $page = null, ?int $items_per_page = null, bool $set_full_url = false): LengthAwarePaginator
PaginatorHelper::appendCleanedRequest(LengthAwarePaginator $paginator, Request $request): void
PaginatorHelper::setFullURL(LengthAwarePaginator $paginator): void
```

**Trait Usage Example:**

```php
// In your Eloquent model
use Equidna\Toolkit\Traits\Database\Paginator;

// Usage in a query scope
$results = $this->scopePaginator($query, $page, $pageName, $items_per_page, $set_full_url, $transformation);
```

Pagination length is set via config:
`config/equidna.php`

```php
return [
    'paginator' => [
        'page_items' => 15,
    ],
];
```

---

## Service Provider

### EquidnaServiceProvider

**Namespace:** `Equidna\Toolkit\Providers`

Registers and publishes package config, and binds custom exception handlers for Laravel.

---

## Exception Classes

Custom exceptions for each error response, with integrated logging and rendering. All exceptions share the following constructor signature:

```php
__construct(string $message = '...', ?Throwable $previous = null, array $errors = [])
```

Available exceptions:

- `BadRequestException`
- `UnauthorizedException`
- `ForbiddenException`
- `NotFoundException`
- `NotAcceptableException`
- `ConflictException`
- `UnprocessableEntityException`
- `TooManyRequestsException`

**Example:**

```php
throw new BadRequestException('Invalid input', $previousException, ['field' => 'error']);
```

Each exception logs the error and returns the appropriate response via `ResponseHelper`. The `$errors` array is optional and can be used to provide additional error details.

---

## Configuration

All config is referenced relative to the provider directory.
Example:
`config('equidna.paginator.page_items')`

---

## Installation & Usage

- Add the service provider to `config/app.php`:
  ```php
  'providers' => [
      Equidna\Toolkit\Providers\EquidnaServiceProvider::class,
  ]
  ```
- Publish config:
  ```sh
  php artisan vendor:publish --tag=equidna:config
  ```
