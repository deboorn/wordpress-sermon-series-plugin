<?php

class SermonPlugin_Router
{
    public static $shortcodePrefix = "sermonplugin_";
    public static $defaultRoute = 'index-series';
    public static $controllers = array(
        'series'  => 'SermonPlugin_Controller_Admin_Series',
        'sermons' => 'SermonPlugin_Controller_Admin_Sermons',
        // add additional controllers here
    );

    public static function hookAdminMenu()
    {
        add_menu_page('Manage Sermons', 'Sermons Series', 'manage_options', 'series-index', array('SermonPlugin_Router', 'routeAdmin'));
    }

    public static function throw404()
    {
        global $wp_query;
        $wp_query->set_404();
        require TEMPLATEPATH . '/404.php';
        exit;
    }

    public static function getUri()
    {
        return $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
    }

    public static function redirect($url)
    {
        @wp_redirect($url);
        // word around for WP sending out header info.
        echo "<meta http-equiv='refresh' content='0; url={$url}'>";
        exit();
    }

    public static function redirectPath($path, $queryStr = null)
    {
        static::redirect($_SERVER['PHP_SELF'] . '?page=' . $path . $queryStr);
    }

    public static function loadView($viewPath, $params = array())
    {
        // additional sanitizing can be performed here
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        require SERMONPLUGIN_DIR . "views/{$viewPath}.php";
        $html = ob_get_clean();
        return $html;
    }

    public static function routeAdmin()
    {
        list($action, $controller) = explode('-', SermonPlugin_Input::param('action', static::$defaultRoute));
        $action = "action" . ucfirst($action);
        if (!array_key_exists($controller, static::$controllers) || !method_exists(static::$controllers[$controller], $action) || !is_callable(array(static::$controllers[$controller], $action))) {
            static::throw404();
        }
        call_user_func(array(static::$controllers[$controller], $action));
    }

    public static function seriesIndex($attributes, $html = null)
    {
        $attributes = shortcode_atts(array(
            'sermonpageurl' => null,
            'columns'       => '3',
            'limit'         => '100',
        ), $attributes, 'series_index');

        SermonPlugin_Controllers_Series::actionIndex($attributes);
    }

    public static function seriesJson($attributes = null)
    {
        $attributes = shortcode_atts(array(
            'limit' => SermonPlugin_Input::get('limit', 20),
        ), $attributes, 'series_json');

        SermonPlugin_Controllers_Series::actionSeriesJson($attributes);
    }

    public static function sermonTitle($title)
    {
        global $wp_query;
        $post = $wp_query->get_queried_object();
        if (!$post || $title != $post->post_title) {
            return $title;
        }

        if (SermonPlugin_Input::param('sermon') && ($sermon = SermonPlugin_Model_Sermons::find(SermonPlugin_Input::param('sermon')))) {
            return $sermon->title;
        }
        if (SermonPlugin_Input::param('series') && ($series = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('series')))) {
            list($count, $rows) = SermonPlugin_Model_Sermons::search(array('series_id' => $series->id), 1, 0, 'sermon_date', 'desc');
            if ($count) {
                $sermon = current($rows);
                return $sermon->title;
            }
        }
        return $title;
    }

    public static function watchSermon()
    {
        SermonPlugin_Controllers_Sermon::actionWatchSermon();
    }

    public static function currentSeries($attributes, $html = null)
    {
        $attributes = shortcode_atts(array(
            'sermonpageurl' => null,
        ), $attributes, 'current_series');
        SermonPlugin_Controllers_Series::actionCurrentSeries($attributes, $html);
    }

    public static function install()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();
        $sql = file_get_contents(SERMONPLUGIN_DIR . 'assets/install.sql');
        $sql = str_replace("{wp_prefix}", $wpdb->prefix, $sql);
        $sql = str_replace("{charset}", $charsetCollate, $sql);

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        update_option( "sermonplugin_db_version", SERMONPLUGIN_VERSION);

        foreach(explode(";", $sql) as $query){
            dbDelta($query);
        }
    }


    public static function currentSeriesLink($attributes, $html = null)
    {
        $attributes = shortcode_atts(array(
            'sermonpageurl' => null,
        ), $attributes, 'current_series');
        SermonPlugin_Controllers_Series::actionCurrentSeriesLink($attributes, $html);
    }

    public static function hookAdmin()
    {
        add_action('admin_menu', array('SermonPlugin_Router', 'hookAdminMenu'));
    }

    public static function registerShortCodes()
    {
        add_shortcode(static::$shortcodePrefix . "series_index", array('SermonPlugin_Router', 'seriesIndex'));
        add_shortcode(static::$shortcodePrefix . "watch_sermon", array('SermonPlugin_Router', 'watchSermon'));
        add_shortcode(static::$shortcodePrefix . "current_series", array('SermonPlugin_Router', 'currentSeries'));
        add_shortcode(static::$shortcodePrefix . "current_series_link", array('SermonPlugin_Router', 'currentSeriesLink'));
        add_shortcode(static::$shortcodePrefix . "series_json", array('SermonPlugin_Router', 'seriesJson'));
        add_filter('the_title', array('SermonPlugin_Router', 'sermonTitle'));
    }

}

