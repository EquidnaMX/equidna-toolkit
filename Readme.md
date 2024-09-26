# Equidna Tooklit

---

Equidna toolkit is a Laravel collection of Helpers, Traits and Middleware aimed to solve common tasks during project development

---

## Middleware

### ExcludeFromHistory

**Namespace** _Equidna\Toolkit\Http\Middleware_

Is a middleware that prevents the current request to be stored in the session as current URL

## Traits

### HasCompositeProimaryKey

**Namespace** _Equidna\Toolkit\Traits\Database_

Enables an eloquent model to have a composite primary key

## Helpers

### RouteHelper

**Namespace** _Equidna\Toolkit\Helpers_

Provides static methods for knowing if a request is from web,api or hook

> RouteHelper::isWeb()
> RouteHelper::isApi()
> RouteHelper::isHook()

### ResponseHelper

**Namespace** _Equidna\Toolkit\Helpers_

Provides static methods to handle error responses, each method returns a RedirectResponse to the provided URL or back() if the request was made from
web or a Response with the apropiate respose code if otherwise.

> ResponseHelper::badRequest(string $message, string $forward_url = null)

> ResponseHelper::unauthorized(string $message, string $forward_url = null)

> ResponseHelper::forbidden(string $message, string $forward_url = null)

> ResponseHelper::notFound(string $message, string $forward_url = null)

> ResponseHelper::error(string $message, string $forward_url = null)

The ResponseHelper::handleException(Exception $exception, string $forward_url = null) receives and exception and return the apropiate response using the previous functions
