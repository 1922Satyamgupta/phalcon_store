<?php

use Phalcon\Mvc\Controller;


class OrdersController extends Controller
{
    public function indexAction()
    {
        
    }

    public function addorderAction() {
        $order = new Orders();
        // print_r($this->request->getPost());
        // die();
        $order->assign(
            $this->request->getPost(),
            [
                'cust_name',
                'cust_address',
                'zipcode',
                'products',
                'quantity'
            ]
        );

        $order->save();


    }

    public function vieworderAction() {
        $this->view->orders = Orders::find();
        
    }
}