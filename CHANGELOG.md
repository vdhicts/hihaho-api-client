# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to 
[Semantic Versioning](https://semver.org/spec/v2.0.0.html). Please note this changelog affects this package and not the 
HiHaHo API.

## [6.0.0]

### Added

- Add support for Laravel 12.
- Add support for PHP 8.4.

### Removed

- Drop support for Laravel version older than 11.
- Drop support for PHP versions older than 8.2.

## [5.0.0]

### Changed

- Update to Laravel 11.

## [4.0.0]

### Changed

- Update to Laravel 10.

## [3.0.0]

### Changed

- Update to Laravel 9.

## [2.1.0]

### Added

- Add support for pagination to the `allVideos()` and `searchVideos()` endpoints.

## [2.0.0]

### Changed

- Switch to using the HTTP Client of Laravel. All endpoints will now return the `Illuminate\Http\Client\Response`.

## [1.0.0]

### Added

- Add the initial HiHaHo API implementation.
