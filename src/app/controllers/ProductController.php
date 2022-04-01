<?php

use Phalcon\Mvc\Controller;

class ProductController extends Controller
{

    public function IndexAction()
    {
        $user = new Products();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'description',
                'tag',
                'price',
                'stock'
            ]
        );
        $values = Setting::find('id = 1');
        $eventsManager = $this->di->get('EventsManager');
        $val = $eventsManager->fire('NotificationListners:checkzip', $user, $values);
        $success = $val->save();
        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>" . implode("<br>", $user->getMessages());
        }
    }

    public function addProductAction()
    {
        $this->view->users = Products::find();
    }
}
