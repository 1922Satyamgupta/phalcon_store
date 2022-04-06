<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

class LoginController extends Controller
{
    public function indexAction()
    {
        $this->view->user = Users::find();
    }
    public function loginAction()
    {
        $this->session  = $this->container->getSession();
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('password');
        $this->session->set('email', $email);
        $this->session->set('password', $pass);
        $user = new Users();
        $senitize =  new \App\Components\MyEscaper();
        $takeData = $senitize->senitizeLogin();
        $user = Users::findFirst(['username = "' . $takeData[0] . '"']);
        if ($takeData[0] == "" && $takeData[1] == "") {
            echo "insert username and password";
            $this->logger->getAdapter('login')->begin();

            $this->logger->error('field vaccant!!');

            $this->logger->getAdapter('login')->commit();
        } elseif ($user->username == $takeData[0] && $user->password == $takeData[1]) {
            $this->logger->getAdapter('login')->begin();

            $this->logger->alert('login successful!! ');
            $this->logger->getAdapter('login')->commit();
            header("Location: http://localhost:8080");
        } else {
            header("Location: http://localhost:8080/login/index");
            $this->logger->getAdapter('login')->begin();

            $this->logger->error('wrong email or password! ');
            $this->logger->getAdapter('login')->commit();
        }
    }
    public function logoutAction() {


        $this->session->destroy();
        $this->response->redirect('users/dashboard');

}
}
