<?php

use Phalcon\Mvc\Controller;


class AddcontrolController extends Controller
{
    public function indexAction()
    {
       

        }
        public function registerAction() {
            $add = new Addcontrols();

        $add->assign(
            $this->request->getPost(),
            [
                'controller',
                'action',
            ]
        );
      
         $add->save();
          header("Location: http://localhost:8080/role");

        }
    
}
