# Repository Guidelines

## Project Structure & Module Organization
Laravel application code lives in `app/` (HTTP controllers, models, jobs) and reusable support code under `app/Support`. HTTP entrypoints are defined in `routes/web.php` for browser traffic and `routes/api.php` for JSON endpoints. Blade templates sit in `resources/views`, while front-end assets (JS, CSS) live in `resources/js` and `resources/css`; Vite outputs to `public/build`. Tests mirror production code inside `tests/Feature` and `tests/Unit`. Configuration files reside in `config/`, and seeders/factories are in `database/`.

## Build, Test, and Development Commands
Install PHP dependencies with `composer install` and JS dependencies with `npm install`. Run the local server via `php artisan serve` and compile assets in watch mode with `npm run dev`. Use `npm run build` for production asset bundles. Execute the Laravel test suite using `php artisan test`; call `phpunit` directly for more granular options. Clear caches (`php artisan config:clear`, `php artisan cache:clear`) whenever configuration or route files change.

## Coding Style & Naming Conventions
Use PSR-12 for PHP (4-space indents) and follow Laravel idioms for controllers, requests, and resource classes. Prefer descriptive class names (e.g., `AccountReconciliationService`) and snake_case for database columns. Keep Blade templates concise and extract reusable components into `resources/views/components`. Front-end scripts should use ES modules and follow standard Prettier spacing; run `./vendor/bin/pint` before committing to auto-format PHP.

## Testing Guidelines
Organize tests by capability: end-to-end HTTP flows in `tests/Feature`, pure logic in `tests/Unit`. Name test methods with intent (`test_guest_cannot_access_dashboard`). Provide factories/seeds when touching the database. Aim to cover new controllers, jobs, and services with at least one Feature test. Run `php artisan test --parallel` before pushing to catch race issues early.

## Commit & Pull Request Guidelines
Write commits in the imperative mood (`Add dashboard authorization`) and keep them focused. Reference ticket IDs in the first line when applicable. Pull requests should describe the change, list verification steps (`php artisan test`, `npm run build`), and include screenshots or API samples for UI or contract updates. Request review from a teammate familiar with the affected module and ensure CI passes before merging.

## Environment & Security Notes
Copy `.env.example` to `.env` and set `APP_KEY` via `php artisan key:generate`. Never commit secrets or compiled assets. Use HTTPS for external callbacks and validate all webhooks in dedicated middleware under `app/Http/Middleware`.
