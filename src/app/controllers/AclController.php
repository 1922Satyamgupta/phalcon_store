<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class AclController extends Controller
{
    public function CreateTokenAction()
    {
        $signer  = new Hmac();

        // Builder object
        $builder = new Builder($signer);

        $now        = new DateTimeImmutable();
        $issued     = $now->getTimestamp();
        $notBefore  = $now->modify('-1 minute')->getTimestamp();
        $expires    = $now->modify('+1 day')->getTimestamp();
        $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

        // Setup
        $builder
            ->setAudience('https://target.phalcon.io')  // aud
            ->setContentType('application/json')        // cty - header
            ->setExpirationTime($expires)               // exp 
            ->setId('abcd123456789')                    // JTI id 
            ->setIssuedAt($issued)                      // iat 
            ->setIssuer('https://phalcon.io')           // iss 
            ->setNotBefore($notBefore)                  // nbf
            ->setSubject('admin')   // sub
            ->setPassphrase($passphrase)                // password 
        ;

        // Phalcon\Security\JWT\Token\Token object
        $tokenObject = $builder->getToken();

        // // The token
        // echo $tokenObject->getToken();
        // die;
    }
    public function BuildAclAction()
    {

        $aclfile = APP_PATH . '/security/acl.cache';
        if (true !== is_file($aclfile)) {
            $acl = new Memory();
            try {
                $parser = new Parser();
                $value = Users::find('email = "aaa"');
                $tokenobject = $parser->parse($value[0]->role);
                $now = new \DateTimeImmutable();
                $expire = $now->getTimestamp();
                $validator = new Validator($tokenobject, 100);
                $validator->validateExpiration($expire);
                $claims = $tokenobject->getClaims()->getPayload();
                // print_r($claims['sub']);
                // die;
            } catch (\Exception $e) {
                echo $e->message;
                die;
            }
           
            $acl->addRole($claims['sub']);
            $acl->addComponent("Product", [
                'index'
            ]);
            $acl->allow($claims['sub'], "*", "*");

            file_put_contents($aclfile, serialize($acl));
        } else {
            $acl = unserialize(file_get_contents($aclfile));
            $value = Users::find('email != "aaa"');
            // print_r($value[1]->name);
            // die();
            $parser = new Parser();
            for($i = 0; $i < count($value); $i++) {
                $tokenobject = $parser->parse($value[$i]->role);
                // print_r($tokenobject);
                // die;
                $now = new \DateTimeImmutable();
                $expire = $now->getTimestamp();
                $validator = new Validator($tokenobject, 100);
                $validator->validateExpiration($expire);
                $claims = $tokenobject->getClaims()->getPayload();
                // print_r($claims['sub']);
                // die;
                $acl->addRole($claims['sub']);
                $acl->addComponent("Product", [
                    'index'
                ]);
                $acl->allow($claims['sub'], "Product", "index");
            }

            file_put_contents($aclfile, serialize($acl));
        }
    }
}
