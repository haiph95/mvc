<?php


namespace core\Helper;


use ArrayAccess;

class Collection implements ArrayAccess
{

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->$offset) ? $this->$offset : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_NUMERIC_CHECK);
    }


    public function toArray()
    {
        $array = array();

        foreach ($this as $obj) {
            $array[] = (array) $obj;
        }

        return $array;
    }

    /**
     * @param $field
     * @return array
     */
    public function lists($field)
    {
        $lists = array();
        foreach ($this as $value)
        {
            $lists[] = $value->{$field};
        }

        return $lists;
    }

    /**
     * @param int $offset
     * @return null
     */
    public function first($offset = 0)
    {
        return isset($this->$offset) ? $this->$offset : null;
    }

    /**
     * @param null $offset
     * @return null
     */
    public function last($offset=null)
    {
        $offset = count($this->toArray())-1;
        return isset($this->$offset) ? $this->$offset : null;
    }

    /**
     * @param $key
     * @return null
     */
    public function item($key)
    {
        return isset($this->$key) ? $this->$key : null;
    }

    public function __toString()
    {
        header("Content-Type: application/json;charset=utf-8");
        return $this->toJson();
    }
}