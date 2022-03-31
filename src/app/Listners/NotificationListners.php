<?php

namespace App\Listners;


use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Acl\Role;


class NotificationListners extends Injectable
{
    // public function afterSend(Event $event, \App\Components\HelperClass $component) {
    //     $logger = $this->di->get('logger');
    //     $logger->info('after Notification');
    //  }
    //  public function beforeSend(Event $event, \App\Components\HelperClass $component) {
    //        $logger = $this->di->get('logger');
    //        $logger->info('before Notification');
    //    }
    public function checkzip(Event $event, $product, $setting)
    {

        if ($product->price == null) {
            $product->price = $setting[0]->price;
        }
        if ($product->stock == null) {
            $product->stock = $setting[0]->stock;
        }
        if ($product->zipcode == null) {
            $product->zipcode = $setting[0]->zipcode;
        }
        if ($setting[0]->name_tag == 'tag') {
            $product->name = $product->name .''.$product->tag;
        }
        return $product;
    }
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application) {
        $aclfile = APP_PATH. '/security/acl.cache';
        if(true == is_file($aclfile)) {
            $acl = unserialize(file_get_contents($aclfile));
        }
        $role = $application->request->get('role');
        $control = $this->router->getControllerName();
        $act = $this->router->getActionName();
       
        if(!$role || true !== $acl->isAllowed($role, "$control", "$act")) {
            echo "Access denied("; die;
        } else {
          
        }

    }
}
