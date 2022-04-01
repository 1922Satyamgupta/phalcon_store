<?php

namespace App\Listners;

use DateTime;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Acl\Role;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;


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
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application) 
    {

        $aclfile = APP_PATH . '/security/acl.cache';
        $controller = ucwords($this->router->getControllerName());
        $action = $this->router->getActionName();
        $bearer = $application->request->get('bearer') ?? 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImN0eSI6ImFwcGxpY2F0aW9uXC9qc29uIn0.eyJhdWQiOlsiaHR0cHM6XC9cL3RhcmdldC5waGFsY29uLmlvIl0sImV4cCI6MTY0ODgxNDkwNSwianRpIjoiYWJjZDEyMzQ1Njc4OSIsImlhdCI6MTY0ODcyODUwNSwiaXNzIjoiaHR0cHM6XC9cL3BoYWxjb24uaW8iLCJuYmYiOjE2NDg3Mjg0NDUsInN1YiI6ImFkbWluIn0.hJp7gDMRd9lKI8DEvlEe7elakDzJgmMaDYtOcNH35hkJ4jzj28V-LTLDMVWKYueJcNoc9ToZo1wkQW_vRA-TqA';
        // print_r($bearer);
        // die;
        if ($bearer) {
            if (true === is_file($aclfile)) {
                $acl = unserialize(file_get_contents($aclfile));
                try {
                    $parser = new Parser();
                    $tokenobject = $parser->parse($bearer);
                    $now = new \DateTimeImmutable();
                    $expire = $now->getTimestamp();
                    $validator = new Validator($tokenobject, 100);
                    $validator->validateExpiration($expire);
                    $claims = $tokenobject->getClaims()->getPayload();
                    // print_r($acl);
                    // die;
                } catch (\Exception $e) {
                    echo "bearer not find";
                    die;
                }
                if ($claims['sub'] == 'admin') {
                    $action = ucwords($this->router->getActionName());
                }

                if (true !== $acl->isAllowed($claims['sub'], $controller, $action)) {
                    echo "Access Denied";
                    // print_r($acl);
                    die();
                }
            }
        } else {

            echo "we dont find bearer!!";
            die;
        }
    }
}
