# Release Notes

## v0.3 - 2026-09-12

- Cannot like an Eloquent model that has already been liked by the authenticated user.
- Cannot unlike an Eloquent model that has not been liked by the authenticated user.

## v0.2.1 - 2026-09-04

- Update the `usage` section in the readme.md file.

## [Unreleased](https://github.com/kevinb1989/likeable/compare/Stop Using the Hidden and Fillable Attributes...HEAD)

## [Stop Using the Hidden and Fillable Attributes](https://github.com/kevinb1989/likeable/compare/0.1...Stop Using the Hidden and Fillable Attributes) - 2026-09-04

Because the following attributes were not yet supported till Laravel 13.x:

- `Illuminate\Database\Eloquent\Attributes\Fillable`
- `Illuminate\Database\Eloquent\Attributes\Hidden`

We will revert to the `$fillable` and `$hidden` properties.

## [0.1](https://github.com/kevinb1989/likeable/compare/v0.1.0...0.1) - 2026-09-03

- `like()`
- `unlike()`
- the `liked` custom attribute, check if the eloquent model is currently liked by the authenticated user.

## [v0.1.0](https://github.com/kevinb1989/likeable/compare/...v0.1.0) - 202x-xx-xx

Initial pre-release.
