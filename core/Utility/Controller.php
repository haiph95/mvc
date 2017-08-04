<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/4/2017
 * Time: 1:51 PM
 */

namespace core\Utility;


abstract class Controller
{

    protected $route_params;

    public $view;


    /**
     * Controller constructor.
     * @param $route_params
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
        $this->view = new View();
    }


    public function __call($name, $args)
    {
        $method = $name;

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array(array($this, $method), $args);
                $this->after();
            }
        } else {
            throw new \Exception("Phương thức $method không nằm trong controller " . get_class($this));
        }
    }

    /**
     * Kiểm tra trước khi thực thi action, return false để dừng lại action
     * @return bool
     */
    protected function before()
    {

    }

    /**
     * Sau khi thực thi action trong controller
     */
    protected function after()
    {

    }
}