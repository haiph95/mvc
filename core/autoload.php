<?php



class autoload
{

    /**
     * Application constructor.
     */
    public function __construct()
    {
        spl_autoload_register(array($this, '_autoload'));
    }

    /**
     * @param $file
     */
    public function _autoload($file)
    {
        $file = str_replace("\\", "/", trim($file, '\\')) . '.php';
        if (file_exists($file))
        {
            require_once($file);
        }
    }
}