<?php

// declare(strict_types=1);

namespace App\Console;

use Phalcon\Cli\Task;
// use Phalcon\Security\JWT\Builder;
// use Phalcon\Security\JWT\Signer\Hmac;
// use Phalcon\Security\JWT\Token\Parser;
// use Phalcon\Security\JWT\Validator;
use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class UserTask extends Task
{
    public function getTokenAction($role = 'admin')
    {
       echo $role. PHP_EOL;
    }

    public function deletelogAction()
    {
        $b = scandir(APP_PATH."/logs/", 1);
        foreach($b as $val)
        {
            if($val!='..' && $val!='.')
            {
                unlink(APP_PATH."/logs/$val");
            }
        }
        echo "All File Deleted";
        die();
    }
    public function createTokenAction($role)
    { 
        if ($role == 'admin') {
            $key = "example_key";
            $payload = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "role" => $role
            );
            $jwt = JWT::encode($payload, $key, 'HS256');

            echo $jwt;
        }
    }
    public function defaultAction($price, $stock)
    {
        $obj =  Setting::findFirst(1);
        $obj->default_price = $price;
        $obj->default_stock = $stock;
        $uadate = $obj->update();
        echo "Setting sucessfully upload!!";
    }
    public function countProdsAction()
    {
        $product =  Products::count([
            'conditions' => 'stock < :stock:',
            'bind' => [
                'stock' => 10,
            ]
        ]);
        echo "count = " . $product;
    }
    public function removeACLAction()
    {
        unlink(APP_PATH . "/security/acl.cache");

        echo " Acl cache deleted successfully!!";
    }
    public function fetchOrdersAction() {
        $current_date = Date('y-m-d');
        $order =  Orders::findFirst([
            'conditions'=>'date=:current_date:',
            'bind'=>[
                'current_date'=>$current_date
            ],
            'order' => 'date DESC'
        ]);
        echo "Order id: ".$order->id;
        echo "Order_customer name =".$order->cust_name;
        echo "Order_customer address =".$order->cust_address;
        echo "Order_Zipcode =".$order->zipcode;
        echo "Order_Product = ".$order->products;
        echo "Order_Quantity =".$order->quantity;
    }

}