<?php

namespace controller;

use core\QueryBuilder\DB;
use core\Utility\Controller;

class PublicController extends Controller
{
    public function index()
    {
        $model = DB::getInstance();
        $all = $model->table('news')->get();
        var_dump($all);die;
    }
}