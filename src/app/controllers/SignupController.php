<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
//---------------------
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SignupController extends Controller{

    public function IndexAction(){

    }

    public function registerAction(){
        $role = $this->request->getPost('role');
        $name = $this->request->getPost('name');
        $signer  = new Hmac();

        // Builder object
        // $builder = new Builder($signer);

        // $now        = new DateTimeImmutable();
        // $issued     = $now->getTimestamp();
        // $notBefore  = $now->modify('-1 minute')->getTimestamp();
        // $expires    = $now->modify('+1 day')->getTimestamp();
        // $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

        // // Setup
        // $builder
        //     ->setAudience('https://target.phalcon.io')  // aud
        //     ->setContentType('application/json')        // cty - header
        //     ->setExpirationTime($expires)               // exp 
        //     ->setId('abcd123456789')                    // JTI id 
        //     ->setIssuedAt($issued)                      // iat 
        //     ->setIssuer('https://phalcon.io')           // iss 
        //     ->setNotBefore($notBefore)                  // nbf
        //     ->setSubject($this->request->getPost('role'))   // sub
        //     ->setPassphrase($passphrase)                // password 
        // ;

        // // Phalcon\Security\JWT\Token\Token object
        // $tokenObject = $builder->getToken();
        // // The token
        // $role= $tokenObject->getToken();
        //-------------------------jwt third party----------------------
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "role" => $role,
            "name" => $name
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($payload, $key, 'HS256');

        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email',
                'password',
                'role'
            ]
        );
        $user->role = $jwt;
        $user->name = $jwt;
        // print_r($user->role);
        // echo "<br><br>";
        // print_r($user->name);
        // die;

        $success = $user->save();

        $this->view->success = $success;

        if($success){
            $this->view->message = "Register succesfully";
        }else{
            $this->view->message = "Not Register succesfully due to following reason: <br>".implode("<br>", $user->getMessages());
        }
    }
}