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
