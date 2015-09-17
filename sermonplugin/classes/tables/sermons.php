<?php

class SermonPlugin_Table_Sermons extends SermonPlugin_Table
{
    protected $name = "sermontable";
    protected $perPage = 10;

    public function __construct()
    {
        parent::__construct(array(
            'singular' => __('sermon', $this->name),
            'plural'   => __('sermons', $this->name),
            'ajax'     => false
        ));
    }

    public function no_items()
    {
        _e('No Results. Please add a new sermon to series.');
    }

    public function column_default($item, $columnName)
    {
        return $item->{$columnName};
    }

    public function get_sortable_columns()
    {
        $list = array();
        foreach (SermonPlugin_Model_Sermons::getProperties() as $key => $title) {
            $list[$key] = array($key, false);
        }
        return $list;
    }

    public function get_columns()
    {
        $list = array('cb' => '<input type="checkbox" />');
        foreach (SermonPlugin_Model_Sermons::getProperties() as $key => $title) {
            $list[$key] = __($title, $this->name);
        }
        return $list;
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="sermons[]" value="%s" />', $item->id);
    }

    public function column_title($item)
    {
        return sprintf('%1$s %2$s', $item->title, $this->row_actions(array(
            'edit'   => sprintf('<a href="?page=%s&action=edit-sermons&id=%s">Edit</a>', SermonPlugin_Input::param('page'), $item->id),
            'delete' => sprintf('<a class="del-btn" href="?page=%s&action=delete-sermons&id=%s">Delete</a>', SermonPlugin_Input::param('page'), $item->id),
        )));
    }

    public function column_audio_url($item)
    {
        if(!$item->audio_url) return null;
        return sprintf("<audio controls src='%s'/>", $item->audio_url);
    }

    public function column_video_embed($item){
        return sprintf("<div style='max-height:100px; overflow:auto;'>%s</div>", $item->video_embed);
    }

    public function column_sermon_date($item)
    {
        return parent::get_timestamp_column($item->sermon_date);
    }

    public function column_created_at($item)
    {
        return parent::get_timestamp_column($item->created_at);
    }

    public function column_updated_at($item)
    {
        return parent::get_timestamp_column($item->updated_at);
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array('id', 'series_id', 'description', 'created_at');
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        list($count, $rows) = SermonPlugin_Model_Sermons::search(
            SermonPlugin_Input::param(), $this->perPage,
            ($this->get_pagenum() - 1) * $this->perPage,
            SermonPlugin_Input::param('orderBy', 'sermon_date'),
            SermonPlugin_Input::param('order', 'desc')
        );
        $this->set_pagination_args(array('total_items' => $count, 'per_page' => $this->perPage));
        $this->items = $rows;
    }

}


