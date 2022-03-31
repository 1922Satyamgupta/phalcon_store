<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

class AclController extends Controller
{
    public function indexAction() {

    }
    public function BuildAclAction()
    {

        $role = $this->request->get('role');
        $control = $this->request->get('controller');
        // print_r("'$control[0]'");
        // die;
        $act = $this->request->get('action');
        // print_r($act);
        // die;
      
        $aclfile = APP_PATH. '/security/acl.cache';
        if (true !== is_file($aclfile)) {
            $acl = new Memory();
            $acl->addRole("$role");
            // print_r($act);
            // die;
            for($i = 0; $i <count($act); $i++) {
          
              
                $acl->addComponent(
                    "$control[$i]",
                    [
                        "$act[$i]",
                    ]
                );
                $acl->allow("$role", "$control[$i]", "$act[$i]");
            
            // $acl->allow('manager', 'test', 'eventtest');
            // $acl->deny('guest', '*', '*');
            file_put_contents(
                $aclfile,
                serialize($acl)
            );
        }
    }
        else {
            $acl = unserialize(
                file_get_contents($aclfile)
            );
        }
        for($i = 0; $i < count($act); $i++) {
            if(true == $acl->isAllowed("$role", "$control[$i]", "$act[$i]")) {
                echo "Access granted";
             } else {
                 echo "Access denied!!";
             }
}
        }
    }