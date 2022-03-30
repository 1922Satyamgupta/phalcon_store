<?php

namespace App\Components;

use  Phalcon\Di\Injectable;

class HelperClass extends Injectable
{
    public function getCurrentDate()
    {
        $eventsManager = $this->di->get("EventsManager");
        $eventsManager->fire('NotificationListners:beforeSend', $this);
        $date = date("Y-m-d");
        $eventsManager->fire('NotificationListners:afterSend', $this);
        return $date;
    }
    public function getCurrentDatetime()
    {
        return date("Y-m-d H:i:s");
    }
    public function setTimezone($zone = "")
    {
        $this->currentZone  = $zone;
    }
    public function getTimezone($zone = "")
    {
        return $this->currentZone  = $zone;
    }
}
