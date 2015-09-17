<?php

/*
Plugin Name: Sermon Plugin
Plugin URI: http://sermonplugin.com
Description: Add responsive audio/video sermons to your church website.
Author: Rapid Digital LLC
Version: 1.0.0
Author URI: http://rapiddigitalllc.com
*/

/**
 * NOTICE        - This plugin requires purchasing a paid license per installation. Please do not pirate church software.
 * Modifications - Modifications are allowed but at your own risk. Sorry, No refunds or free support for modifications.
 * MVC Design    - This plugin uses a Object Oriented Model View Controller design. Knowledge of OO PHP is required for modification.
 * PHP 5.3+      - This plugin is designed for modern PHP 5.3+. However, it may function on older versions.
 *               - We have no intention of supporting older (less secure) versions of PHP.
 * Questions?    - Got a question or need a modification? Drop us a line at info@rapiddigitalllc.com
 * Shortcodes    - A list of shortcodes are displayed under the sermon index page in the admin panel.
 */

/**
 * Sermon Plugin MVC Layout:
 *     - /assets/* (public css, fonts, js and install SQL)
 *     - /views/admin/* (administration template files used by controllers)
 *     - /views/* (front end template files used by controllers)
 *     - /classes/controllers/* (front controllers)
 *     - /classes/controllers/admin/* (admin controllers)
 *     - /classes/models/* (database table models)
 *     - /classes/tables/* (admin panel table classes)
 *     - /classes/input.php (handles all input sanitizing for plugin)
 *     - /classes/model.php (base model class, extended by plugin models)
 *     - /classes/router.php (handles application MVC routing)
 *     - /classes/table.php (base table class, extended by plugin tables)
 */

if (!function_exists('add_action')) exit();

define('SERMONPLUGIN_URL', WP_PLUGIN_URL . '/sermonplugin/');
define('SERMONPLUGIN_DIR', plugin_dir_path(__FILE__));
define('SERMONPLUGIN_VERSION', '1.0.0');

// Bootstrap Sermon Plugin
require_once SERMONPLUGIN_DIR . "/classes/input.php";
require_once SERMONPLUGIN_DIR . "/classes/model.php";
require_once(SERMONPLUGIN_DIR . "classes/models/series.php");
require_once(SERMONPLUGIN_DIR . "classes/models/sermons.php");
require_once SERMONPLUGIN_DIR . "/classes/table.php";
require_once SERMONPLUGIN_DIR . "/classes/tables/series.php";
require_once SERMONPLUGIN_DIR . "/classes/tables/sermons.php";
require_once SERMONPLUGIN_DIR . "/classes/router.php";
require_once SERMONPLUGIN_DIR . "/classes/controllers/base.php";


if (is_admin()) {
    require_once SERMONPLUGIN_DIR . "/classes/controllers/admin.php";
    require_once SERMONPLUGIN_DIR . "/classes/controllers/admin/series.php";
    require_once SERMONPLUGIN_DIR . "/classes/controllers/admin/sermons.php";
    SermonPlugin_Router::hookAdmin();
    register_activation_hook(__FILE__, array('SermonPlugin_Router', 'install'));

} else {
    require_once SERMONPLUGIN_DIR . "/classes/controllers/series.php";
    require_once SERMONPLUGIN_DIR . "/classes/controllers/sermon.php";
    SermonPlugin_Router::registerShortCodes();
}

if (SermonPlugin_Input::get('series-json')) {
    SermonPlugin_Router::seriesJson();
}


