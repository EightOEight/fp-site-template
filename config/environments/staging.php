<?php
/**
 * Staging overrides.
 *
 * Loaded when WP_ENV=staging. Like production but with verbose logging
 * and indexing disabled.
 *
 * @package FrankenPress\Site
 */

use Roots\WPConfig\Config;

Config::define( 'WP_DEBUG', true );
Config::define( 'WP_DEBUG_DISPLAY', false );
Config::define( 'WP_DEBUG_LOG', true );
Config::define( 'SCRIPT_DEBUG', false );
Config::define( 'AUTOMATIC_UPDATER_DISABLED', true );
Config::define( 'WP_AUTO_UPDATE_CORE', false );
Config::define( 'DISALLOW_INDEXING', true );
