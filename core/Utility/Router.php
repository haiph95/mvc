<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/3/2017
 * Time: 4:41 PM
 */

namespace core\Utility;


use Exception;

class Router
{
    protected $routes = array();


    protected $params = array();

    public function add($route, $params = array())
    {
        // Chuyển route thành regex
        $route = preg_replace('/\//', '\\/', $route);

        // chuyển biến
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;

    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Lấy router trùng và set vào $params
     *
     * @param $url
     * @return bool
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $param) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $param[$k] = $v;
                    }
                }
                $this->params = $param;
                return true;
            }
        }
        return false;
    }

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_obj = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                /** Nếu action trong controller được gọi  */
                if (is_callable(array($controller_obj, $action))) {
                    $controller_obj->$action();
                } else {
                    throw new Exception("Không thể tìm thấy phương thức $action trong controller $controller_obj");
                }
            } else {
                /** Nếu không có controller này */
                throw new Exception("Không tìm thấy controller $controller");
            }
        } else {
            throw new Exception("Không tìm thấy đường dẫn $url", 404);
        }
    }

    /**
     * Chuyển chuỗi theo StudlyCaps
     * VD: post-authors => PostAuthors
     *
     * @param $string
     * @return mixed
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Chuyển chuỗi theo camelCase
     * VD: add-new => addNew
     * @param $string
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }


    /**
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * @param $url
     * @return string
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Lấy namespace của controller class
     * @return string
     */
    public function getNamespace()
    {
        $namespace = 'controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

}