<?php

/**
 * Class SermonPlugin_Model
 * Note: Models require id column as primary key
 */
class SermonPlugin_Model
{
    protected static $tableName;
    protected static $properties;
    protected $newRecord = true;

    public function __construct($properties = array())
    {
        foreach (static::$properties as $key => $label) {
            $this->{$key} = null;
        }
        $this->setAttributes($properties);
    }

    public static function getProperties()
    {
        return static::$properties;
    }

    public static function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . static::$tableName;
    }

    protected static function doSearch($query, $where, $params, $limit, $offset, $orderBy, $sort)
    {
        global $wpdb;
        $sql = $query . " WHERE " . implode(" AND ", $where);
        $orderBy = array_key_exists($orderBy, static::$properties) ? $orderBy : 'id';
        $sort = $sort == "desc" ? "desc" : "asc";
        $sql .= " ORDER BY {$orderBy} {$sort}";
        $sql = $wpdb->prepare($sql, $params);
        $count = $wpdb->get_var(str_replace("*", "COUNT(*)", $sql));
        $sql .= is_numeric($limit) ? " LIMIT " . (int)$limit : "";
        $sql .= is_numeric($offset) ? " OFFSET " . (int)$offset : "";
        $rows = $wpdb->get_results($sql);
        return array($count, $rows, $sql);
    }

    protected static function getQuery()
    {
        $query = "SELECT * FROM " . static::getTableName();
        $where = array("'1'=%s");
        $params = array(1);
        return array($query, $where, $params);
    }

    public function setAttributes($properties = array())
    {
        foreach ($properties as $key => $value) {
            if (!$this->newRecord && $key == 'id') continue;
            if (array_key_exists($key, static::$properties)) {
                $this->{$key} = $value;
            }
        }
    }

    public static function find($id)
    {
        global $wpdb;
        $attributes = (array)$wpdb->get_row("SELECT * FROM " . static::getTableName() . " WHERE id = " . (int)$id);
        if (count($attributes) == 0) return null;
        $model = static::forge($attributes);
        $model->newRecord = false;
        return $model;
    }

    public function beforeInsert()
    {

    }

    public function beforeSave()
    {

    }

    public function delete()
    {
        global $wpdb;
        return $wpdb->delete(static::getTableName(), array('id' => $this->id));
    }

    public function insert()
    {
        global $wpdb;
        $this->beforeInsert();
        $values = array();
        foreach (static::$properties as $key => $label) {
            $values[$key] = $this->{$key};
        }
        if (($r = $wpdb->insert(static::getTableName(), $values))) {
            $this->id = $wpdb->insert_id;
            return true;
        }
        return false;
    }

    public function update()
    {
        global $wpdb;
        $this->beforeSave();
        $values = array();
        foreach (static::$properties as $key => $label) {
            if ($key == 'id') continue;
            $values[$key] = $this->{$key};
        }
        return $wpdb->update(static::getTableName(), $values, array('id' => $this->id));
    }

    public function save()
    {
        if (empty($this->id) && $this->newRecord) {
            return $this->insert();
        }

        return $this->update();
    }


}

