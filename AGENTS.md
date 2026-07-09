# Repository Guidelines

## Project Structure & Module Organization

This is a PHP 8.4 library for integrating Sendcloud with DRY/Oak applications. Source code lives in `src/` and is autoloaded with PSR-4 as `Tnt\Sendcloud\`.

- `src/Api.php`: public API wrapper around Sendcloud operations.
- `src/Client/`: HTTP client and response/error handling.
- `src/Model/`: DRY database models for parcels, labels, and shipment methods.
- `src/Revisions/`: database migration revisions.
- `src/Console/` and `src/Controller/`: CLI sync and webhook entry points.

There is currently no dedicated `tests/` directory; add one when introducing automated tests.

## Build, Test, and Development Commands

Use the root `Makefile`; targets run inside the `dry-sendcloud-dev` Docker service.

- `make docker`: build/start the PHP 8.4 development container.
- `make docker-exec`: open a shell in the container.
- `make yarn-install`: install formatting dependencies with Yarn 4.
- `make format`: run Prettier with the PHP plugin over `src/`.
- `make phpstan`: run `composer phpstan` at level 6.
- `make phpstan-baseline`: regenerate the PHPStan baseline when intentionally accepting existing issues.

The container runs `composer install` on startup. It mounts the repository at `/var/www/html`.

## Coding Style & Naming Conventions

Follow the existing PHP style: 4-space indentation, PSR-4 namespaces, `PascalCase` classes, and descriptive method names such as `getShippingMethods()`. Keep public APIs typed where practical and add PHPDoc array shapes or generic array annotations when PHPStan needs them. Prefer existing DRY/Oak model and revision patterns over new abstractions.

## Testing Guidelines

Run `make phpstan` before handing off changes. When adding behavior tests, place them under `tests/`, mirror the source namespace, and name test classes after the unit under test, for example `SendcloudClientTest`.

## Commit & Pull Request Guidelines

History uses short imperative messages such as `update guzzle` and `Parcel table FK fix.` Keep commits focused and describe the changed behavior. PRs should include purpose, touched areas, migration notes if `src/Revisions/` changes, and validation performed, especially `make format` and `make phpstan`.

## Shortcut Workflow

For `$dry-skills:shortcut`, use this project-level metadata:

- Project name prefix: `dry-sendcloud`
- Story title format: `dry-sendcloud: concise task title`
- Team: use the default `webdev` team from the Shortcut skill unless the user overrides it.
- Project ID, epic, and iteration: no repository-specific override is currently defined; omit them unless provided by the user.

Before creating stories, verify `short` is installed. Prefer the skill scripts (`scripts/create.sh`, `scripts/start.sh`, `scripts/search.sh`) and use branches in the format `<type>/sc-<id>--<slug>`.
