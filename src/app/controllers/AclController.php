<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
$acl = new Memory();
$acl->addRole('admin');
$acl->addRole('developer');
$acl->addRole('client');
// $acl->addComponent(
//     'admi',
//     [
//         'dashboard',
//         'users',
//         'view',
//     ]
// );

// $acl->addComponent(
//     'reports',
//     [
//         'list',
//         'add',
//         'view',
//     ]
// );

// $acl->addComponent(
//     'session',
//     [
//         'login',
//         'logout',
//     ]
// );