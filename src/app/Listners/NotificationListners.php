<?php 
namespace App\Listners;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
class NotificationListners extends Injectable
{
    public function afterSend(Event $event, \App\Components\HelperClass $component) {
        $logger = $this->di->get('logger');
        $logger->info('after Notification');
     }
     public function beforeSend(Event $event, \App\Components\HelperClass $component) {
           $logger = $this->di->get('logger');
           $logger->info('before Notification');
       }
}
