<?php
namespace app\notepad\controller;

use app\common\controller\UserController;
class Index extends UserController
{
    public function index()
    {
        return $this->fetch('index');
    }
}
