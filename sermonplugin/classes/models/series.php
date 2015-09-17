<?php

class SermonPlugin_Model_Series extends SermonPlugin_Model
{
    protected static $tableName = 'sermonplugin_series';

    protected static $properties = array(
        'id'         => 'ID',
        'title'      => 'Series Title',
        'image'      => 'Series Image',
        'start_date' => 'Series Start Date',
        'created_at' => 'Created',
        'updated_at' => 'Updated',
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
        $this->start_date = !is_numeric($this->start_date) ? strtotime($this->start_date) : $this->start_date;
    }

    public function beforeSave()
    {
        $this->updated_at = time();
        $this->start_date = !is_numeric($this->start_date) ? strtotime($this->start_date) : $this->start_date;
    }
}