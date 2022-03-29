<?php 
namespace App\Listners;


use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
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
       public function checkzip(Event $event, $product, $setting) {
         
           if($product->price == null){
               $product->price = $setting[0]->price;
           }
           if($product->stock == null){
            $product->stock = $setting[0]->stock;
        }
        if($product->zipcode == null){
            $product->zipcode= $setting[0]->zipcode;
        }
        if($setting[0]->name_tag == 'tag') {
            $product->name = $product->name.$product->name_tag;
        }
         return $product;
       
       }
}
