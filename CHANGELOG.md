## [0.6.5] - 2025-07-28

### Added

- Introduced `EquidnaServiceProvider` for the Equidna Toolkit Laravel package.
- Automatic merging and publishing of package configuration (`equidna.php`) using `registerConfig()` and `publishConfig()`.
- Registration of custom HTTP exception handlers:
  - `BadRequestException`
  - `UnauthorizedException`
  - `ForbiddenException`
  - `NotFoundException`
  - `NotAcceptableException`
  - `ConflictException`
  - `UnprocessableEntityException`
  - `TooManyRequestsException`
- PSR-12 style compliance, 4-space indentation, and PHPDoc documentation for all methods.

### Changed

- None (initial release).

### Fixed

- None (initial release).
