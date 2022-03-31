<?php

use Phalcon\Mvc\Controller;


class RoleController extends Controller
{
    public function indexAction()
    {
        $this->view->orders = Addcontrols::find();
    }
    public function addAction()
    {
        // $role = $this->request->get('role');
        // $value = Roles::find('id = 1');
        // $value[0]->role = $role;
        // $value[0]->update();
        $act=$this->request->get('action');
        print_r($act);
        die;


    }
}

