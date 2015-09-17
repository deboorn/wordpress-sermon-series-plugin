<?php

class SermonPlugin_Input
{
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function videoEmbed($name)
    {
        return wp_kses($_POST[$name], array('iframe' => array(
            'width'                 => array(),
            'height'                => array(),
            'src'                   => array(),
            'frameborder'           => array(),
            'style'                 => array(),
            'class'                 => array(),
            'webkitallowfullscreen' => array(),
            'mozallowfullscreen'    => array(),
            'allowfullscreen'       => array(),
        )));
    }

    public static function get($param = null, $default = null, $sanitizeWith = 'sanitize_text_field')
    {
        if ($param === null) {
            $cleaned = array();
            foreach ($_GET as $key => $value) {
                $cleaned[$key] = call_user_func($sanitizeWith, $value);
            }
            return $cleaned;
        }
        if (isset($_GET[$param])) return call_user_func($sanitizeWith, $_GET[$param]);
        return call_user_func($sanitizeWith, $default);
    }

    public static function post($param = null, $default = null, $sanitizeWith = 'sanitize_text_field')
    {
        if ($param === null) {
            $cleaned = array();
            foreach ($_POST as $key => $value) {
                $cleaned[$key] = call_user_func($sanitizeWith, $value);
            }
            return $cleaned;
        }
        if (isset($_POST[$param])) return call_user_func($sanitizeWith, $_POST[$param]);
        return call_user_func($sanitizeWith, $default);
    }


    public static function param($param = null, $default = null, $sanitizeWith = 'sanitize_text_field')
    {
        if ($param === null) {
            $cleaned = array();
            foreach ($_REQUEST as $key => $value) {
                $cleaned[$key] = call_user_func($sanitizeWith, $value);
            }
            return $cleaned;
        }
        if (isset($_REQUEST[$param])) return call_user_func($sanitizeWith, $_REQUEST[$param]);
        return call_user_func($sanitizeWith, $default);
    }
}

