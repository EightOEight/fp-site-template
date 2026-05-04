<?php
/**
 * Development overrides.
 *
 * Loaded when WP_ENV=development. Permissive: debug on, cache off,
 * indexing disabled (so dev sites don't accidentally end up in search
 * engines).
 *
 * @package FrankenPress\Site
 */

use Roots\WPConfig\Config;

Config::define( 'SAVEQUERIES', true );
Config::define( 'WP_DEBUG', true );
Config::define( 'WP_DEBUG_DISPLAY', true );
Config::define( 'WP_DEBUG_LOG', false );
Config::define( 'SCRIPT_DEBUG', true );
Config::define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
Config::define( 'DISALLOW_INDEXING', true );

ini_set( 'display_errors', '1' );
