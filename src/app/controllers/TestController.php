<?php

use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    public function checkconfigAction()
    {
        $config = $this->container->get('config');
        $this->view->appName = $config->get('app')->get('version');
    }
    public function dbAction() {
        $config = $this->container->get('config');
        $this->view->db = $config->get('db')->get('host');
        $this->view->user = $config->get('db')->get('username');
        $this->view->pass = $config->get('db')->get('password');
        $this->view->dbname = $config->get('db')->get('dbname');
        echo "Hostname: " .$this->view->db;
        echo "<br>";
        echo  "Username: " .$this->view->user;
        echo "<br>";
        echo "Password: " .$this->view->pass;
        echo "<br>";
        echo "Databasename: " .$this->view->dbname;
        die;

    }
    public function LoaderTestAction() {
        $dateHelper =  new \App\Components\DateHelper();
        echo $dateHelper->getCurrentDate();
    }

    public function EventTestAction()
    {
        $dateHelper =  new \App\Components\HelperClass();
        echo $dateHelper->getCurrentDate();
    
    }
}

