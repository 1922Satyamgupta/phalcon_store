<?php

use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    // public function checkconfigAction()
    // {
    //     $config = $this->container->get('config');
    //     $this->view->appName = $config->get('app')->get('version');
    // }
    // public function dbAction() {
    //     $config = $this->container->get('config');
    //     $this->view->db = $config->get('db')->get('host');

    // }
    public function EventAction()
    {
        $dateHelper =  new \App\Components\HelperClass();
        echo $dateHelper->getCurrentDate();
    }
}
