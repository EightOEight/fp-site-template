# CLAUDE.md

Guidance for Claude Code when working in a forked FrankenPress site.

## What this repo is

A Bedrock-style WordPress site running on the FrankenPress stack
(`fp-runtime` base image + `fp-mu-plugin` baked in + `humanmade/s3-uploads`
for media). It's a **GitHub template** — downstream sites click "Use this
template" and customise.

## Layout

- `web/wp/` — WordPress core (composer-installed; **never committed**).
- `web/app/{plugins,themes,mu-plugins}/` — wp-content. Composer-managed
  via wpackagist; custom code lives directly in those dirs.
- `web/app/mu-plugins/fp/` — `fp-mu-plugin` baked by the runtime image.
  **Don't commit; don't edit.** It's overwritten on every container build.
- `config/application.php` — env-driven config; the lockdown constants
  (`DISALLOW_FILE_EDIT`, `DISALLOW_FILE_MODS`) live here. **Hard-coded
  by design — no env override.**
- `config/environments/{development,staging,production}.php` —
  per-env overrides (debug flags, auto-update disabled, etc.).

## Common edits

- **Add a plugin:** `composer require wpackagist-plugin/<slug>`. Lands in
  `web/app/plugins/<slug>/`.
- **Add a theme:** `composer require wpackagist-theme/<slug>`. Lands in
  `web/app/themes/<slug>/`.
- **Add custom code:** drop a directory under the right `web/app/*`
  subtree and commit it.
- **Bump WP core:** edit the `roots/wordpress` constraint in
  `composer.json`, run `composer update roots/wordpress`.
- **Bump fp-runtime base image:** edit the `FROM ghcr.io/eightoeight/fp-runtime:<tag>`
  reference in `Dockerfile` (or override at build via
  `--build-arg FP_RUNTIME_VERSION=...`).

## Don'ts

- **Don't commit `web/wp/`, `vendor/`, `.env`, `node_modules/`, or
  `web/app/uploads/`.** The `.gitignore` already covers these.
- **Don't put real secrets in `.env`.** Use `wp dotenv salts generate`
  for local dev keys; production uses real env vars injected by the
  deployment.
- **Don't edit `web/wp-config.php` to add config.** Put env-driven
  config in `config/application.php` or a `config/environments/*.php`
  override.
- **Don't relax the lockdown constants** unless you have a very specific
  reason and you understand the consequences. Admin-side plugin installs
  on a containerized FrankenPress site land on ephemeral disk and
  vanish on pod restart — the lockdown prevents this footgun.
- **Don't bake `humanmade/s3-uploads` config into application.php** —
  it's wired through `fp-mu-plugin`'s `S3UploadsBootstrap` from
  `FP_S3_*` env vars. Adding S3 constants directly may double-define.

## Running things

- `make setup` — first-time bootstrap (composer install, `.env` copy)
- `make up` — start the local stack
- `make down` — stop and drop volumes
- `make wp -- <wp-cli args>` — run wp-cli in the site container
- `make lint` — phpcs against `config/` and any custom mu-plugins
- `make logs` — tail site logs
- `make shell` — bash into the site container

## Where things live

- The runtime's behaviour (Caddyfile, Souin config, php.ini) lives in
  the `fp-runtime` repo. **Don't try to override these from the site.**
  The contract is via env vars (`FP_CACHE_TTL`, `REDIS_URL`, `FP_PORT`,
  etc.) — see fp-runtime's README for the full list.
- The mu-plugin's behaviour (S3 bootstrap, cache invalidation) lives in
  `fp-mu-plugin`. The components hook themselves into WP automatically.
- For deployment (Helm chart, Kubernetes manifests), see
  [`fp-charts`](https://github.com/EightOEight/fp-charts).
