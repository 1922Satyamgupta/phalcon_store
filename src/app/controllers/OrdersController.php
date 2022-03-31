<?php

use Phalcon\Mvc\Controller;


class OrdersController extends Controller
{
    public function indexAction()
    {
    }

    public function addorderAction()
    {


        $order = new Orders();
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
        $values = Setting::find('id = 1');
        $eventsManager = $this->di->get('EventsManager');
        $val = $eventsManager->fire('NotificationListners:checkzip', $order, $values);
        $val->save();
    }

    public function vieworderAction()
    {
        $this->view->orders = Orders::find();
    }
}
