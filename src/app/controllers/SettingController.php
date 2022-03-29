<?php

use Phalcon\Mvc\Controller;


class SettingController extends Controller
{
    public function indexAction()
    {

    }
    public function settingAction()
    {
      $tag = $this->request->get('name_tag');
      $price = $this->request->get('price');
      $stock = $this->request->get('stock');
      $zipcode = $this->request->get('zipcode');
      $value = Setting::find('id = 1');
      $value[0]->name_tag = $tag;
      $value[0]->price = $price;
      $value[0]->stock = $stock;
      $value[0]->zipcode = $zipcode;
      $value[0]->update();
      header("Location: http://localhost:8080/");


        
    }
}