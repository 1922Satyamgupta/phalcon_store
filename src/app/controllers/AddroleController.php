<?php

use Phalcon\Mvc\Controller;


class AddroleController extends Controller
{
    public function indexAction()
    {
       

        }
        public function registerAction() {
            $addrole = new Roles();

        $addrole->assign(
            $this->request->getPost(),
            [
                'role'
            ]
        );
      
         $addrole->save();
        //   header("Location: http://localhost:8080/role");

        }
    
}
