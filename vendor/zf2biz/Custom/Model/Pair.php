<?php

namespace Custom\Model;


class Pair
{
    protected static $field_id = 'id';
    protected static $field_name = 'name';

    protected $id = null;
    protected $name = null;

    public function exchangeArray($data)
    {
        $this->id = $data[static::$field_id];
        $this->name = $data[static::$field_name];
    }

    public function toArray() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
        );
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
        );
    }

}
