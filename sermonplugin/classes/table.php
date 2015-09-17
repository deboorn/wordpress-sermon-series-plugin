<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class SermonPlugin_Table extends WP_List_Table
{
    public function get_timestamp_column($value)
    {
        return date_i18n(get_option('date_format'), $value);
    }
}


