<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/3/2017
 * Time: 2:18 PM
 */

namespace core\Helper;


class ObjCollection
{
    public function toJson()
    {
        return json_encode($this, JSON_NUMERIC_CHECK);
    }

    public function toArray()
    {
        return (array)$this;
    }

    public function __toString()
    {
        header("Content-Type: application/json;charset=utf-8");
        return json_encode($this, JSON_NUMERIC_CHECK);
    }
}