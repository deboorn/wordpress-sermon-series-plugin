<?php

class SermonPlugin_Model_Sermons extends SermonPlugin_Model
{

    protected static $tableName = "sermonplugin_sermons";

    protected static $properties = array(
        'id'          => 'ID',
        'series_id'   => 'Series ID',
        'title'       => 'Title',
        'description' => 'Description/Notes',
        'sermon_date' => 'Sermon Date',
        'audio_url'   => 'Audio',
        'video_embed' => 'Video',
        'created_at'  => 'Created',
        'updated_at'  => 'Updated',
    );

    public static function forge($attributes = array())
    {
        return new self($attributes);
    }

    public static function search($searchParams, $limit = null, $offset = null, $orderBy = null, $sort = null)
    {
        list($query, $where, $params) = parent::getQuery();

        // generic searching
        foreach ($searchParams as $key => $value) {
            if (array_key_exists($key, static::$properties)) {
                $where[] = "{$key} = %s";
                $params[] = $value;
            }
        }

        // search title
        if (!empty($searchParams['s'])) {
            $where[] = "title LIKE %s";
            $params[] = "%{$searchParams['s']}%";
        }

        return parent::doSearch($query, $where, $params, $limit, $offset, $orderBy, $sort);
    }

    public function beforeInsert()
    {
        $this->created_at = $this->updated_at = time();
        $this->sermon_date = !is_numeric($this->sermon_date) ? strtotime($this->sermon_date) : $this->sermon_date;
    }

    public function beforeSave()
    {
        $this->updated_at = time();
        $this->sermon_date = !is_numeric($this->sermon_date) ? strtotime($this->sermon_date) : $this->sermon_date;
    }

}