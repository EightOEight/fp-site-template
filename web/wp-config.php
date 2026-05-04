<?php
/**
 * Bedrock-style wp-config.php loader.
 *
 * Defers all configuration to config/application.php so we keep one source
 * of truth for env-driven settings. Plugins/themes should never write to
 * this file.
 *
 * @package FrankenPress\Site
 */

if ( file_exists( $composer = __DIR__ . '/../vendor/autoload.php' ) ) {
	require_once $composer;
}

/** Load config/application.php (Bedrock convention). */
require_once dirname( __DIR__ ) . '/config/application.php';

require_once ABSPATH . 'wp-settings.php';
