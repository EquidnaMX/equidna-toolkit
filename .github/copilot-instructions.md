# Copilot Coding Agent Instructions for equidna-toolkit

## Project Overview

- **equidna-toolkit** is a Laravel-based PHP package providing helpers, middleware, traits, and service providers for modular application development.
- Major components are organized under `src/`:
  - `Helpers/`: Utility classes for routing, pagination, responses, etc.
  - `Http/Middleware/`: Custom middleware for request/session handling.
  - `Providers/`: Service providers for package configuration and bootstrapping.
  - `Traits/Database/`: Eloquent ORM extensions (e.g., composite primary key support).
  - `config/`: Package configuration file (`equidna.php`).

## Key Architectural Patterns

- **Service Provider** (`EquidnaServiceProvider`):
  - Registers and publishes config via Laravel conventions.
  - See `src/Providers/EquidnaServiceProvider.php` for merge/publish logic.
- **Middleware**:
  - Custom middleware (e.g., `ExcludeFromHistory`) manipulates session/request state.
  - Middleware should be registered in the host Laravel app's `Kernel.php`.
- **Helpers**:
  - Static utility classes (e.g., `RouteHelper`) encapsulate request type detection and routing logic.
  - Use null-safe operators and fallback logic for robust request handling.
- **Traits**:
  - `HasCompositePrimaryKey` enables Eloquent models to support composite keys. Override `getKeyName()` to return an array of key names in your model.

## Developer Workflows

- **Build/Install**:
  - Use Composer for dependency management: `composer install` or `composer update`.
- **Testing**:
  - No test directory detected; add tests under `tests/` using PHPUnit if needed.
- **Debugging**:
  - Use Laravel's built-in logging and exception handling. Middleware and helpers use try/catch for fallback logic.

## Project-Specific Conventions

- **Config Pathing**:
  - All config files referenced relative to provider directory (e.g., `__DIR__ . '/../config/equidna.php'`).
- **Session Manipulation**:
  - Middleware may directly modify session keys (e.g., `forget('_previous')`).
- **Composite Key Models**:
  - Models using `HasCompositePrimaryKey` must override `getKeyName()` to return an array.

## Integration Points

- **Laravel Framework**:
  - Relies on Laravel's service provider, middleware, and Eloquent ORM systems.
  - External dependencies managed via Composer (`composer.json`).
- **No custom build scripts or test runners detected.**

## Examples

- Register service provider in `config/app.php`:
  ```php
  'providers' => [
      Equidna\Toolkit\Providers\EquidnaServiceProvider::class,
  ]
  ```
- Example composite key model:
  ```php
  class MyModel extends Model {
      use HasCompositePrimaryKey;
      public function getKeyName() { return ['key1', 'key2']; }
  }
  ```

---

If any conventions or workflows are unclear, please provide feedback so this guide can be improved.
