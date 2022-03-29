<?php

use Phalcon\Mvc\Controller;

class ProductController extends Controller{

    public function IndexAction(){
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

        $success = $user->save();

        $this->view->success = $success;

        if($success){
            $this->view->message = "Register succesfully";
        }else{
            $this->view->message = "Not Register succesfully due to following reason: <br>".implode("<br>", $user->getMessages());
        }

    }

    public function addProductAction(){
        $this->view->users = Products::find();
       
    }
}