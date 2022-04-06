<?php

namespace App\Components;

use Phalcon\Escaper;
use Phalcon\Http\Request;

class MyEscaper
{
  public function senitize()
  {
    $escaper  =  new Escaper();
    $request = new Request();
    $title = array($request->getPost("username"), $request->getPost("password"), $request->getPost("role"));
    $takeData = array(
      "username" =>  $escaper->escapeHtml($title[0]),
      "password" =>  $escaper->escapeHtml($title[1]),
      "role" =>  $escaper->escapeHtml($title[2]),
    );
    return $takeData;
  }

  public function senitizeLogin()
  {
    $escaper  =  new Escaper();
    $request = new Request();
    $username =  $escaper->escapeHtml($request->getPost("username"));
    $password = $escaper->escapeHtml($request->getPost("password"));
    $takeData = array($username, $password);

    return $takeData;
  }
}
