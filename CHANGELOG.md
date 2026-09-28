# Changelog

All notable changes to this package are documented in this file. Versions
follow [Semantic Versioning](https://semver.org). New entries are generated from
commit messages by [dry-ci](https://github.com/TallieuTallieu/dry-ci); past
entries may be edited by hand.

## 3.0.3 - 2026-09-28

### Other changes

- Update the release action runtime
- Make auto-release reruns safe ([sc-9973](https://app.shortcut.com/tallieu--tallieu/story/9973))

## 3.0.2 - 2026-07-09

### Other changes

- Update the GitHub Actions workflows for Node 24 ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- Fix the Yarn setup in the GitHub Actions workflows ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))

## 3.0.1 - 2026-07-09

No notable changes.

## 3.0.0 - 2026-07-09

### Breaking changes

- Requires PHP 8.4 or later ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- Requires `tallieutallieu/dry` `^3.8.1-beta.5` or `^4.0.0`, `tallieutallieu/oak` `^3.0.8`, `tallieutallieu/dry-dbi` `^3.8.0` and `guzzlehttp/guzzle` `^7.13`; upgrade these in your project before updating ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- `Api` and `SendcloudClient` methods now have native parameter and return types: pass arrays to `Api::createParcel()` and to the `$params`/`$body` of `SendcloudClient::get()`, `post()` and `put()`, and a string to `download()`. Classes that extend `Api`, `SendcloudClient`, the models or the revisions must match the new signatures ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))

### Fixes

- `Parcel::delete()` now deletes the parcel's labels; it previously read `$label->delete` as a property ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- Failed requests without an HTTP response now throw a `SendcloudException` instead of a PHP error, and every request error message names the HTTP method ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- The webhook controller rejects payloads that are not JSON objects or have no `action` with a `SendcloudWebhookException`, without PHP warnings ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))

### Other changes

- Add project tooling: Docker development container, Makefile, Prettier and PHPStan (level 6) ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- Add native and PHPDoc types across the package ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))
- Add GitHub workflows for CI (PHPStan, formatting) and releases ([sc-9962](https://app.shortcut.com/tallieu--tallieu/story/9962))

## Earlier history

- **1.0.0** (2020-05-26): First working version, published as `dietervyncke/dry-sendcloud`: a Sendcloud API client (`Api`, `SendcloudClient`) for parcels, shipping methods and label downloads, DRY models and database revisions for parcels, labels and shipment methods, a `sync-shipment-methods` console command and a `sendcloud-webhook/` route that dispatches `ParcelChanged` events.
- **1.0.1** (2020-05-28): Improved error reporting in `SendcloudClient`; exceptions include the HTTP method and status code.
- **1.0.2** (2020-09-08): Added a revision that fixes the label foreign key on the `sendcloud_parcel` table.
- **2.0.0** (2023-09-14): Package renamed to `tallieutallieu/dry-sendcloud` (moved to TallieuTallieu in 2021), `guzzlehttp/guzzle` raised from `^6.5` to `^7.4.5`, and a README with installation and usage docs added.

See the git tags before 3.0.0 for the full history.
