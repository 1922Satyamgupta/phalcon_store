<?php
// print_r(apache_get_modules());
// echo "<pre>"; print_r($_SERVER); die;
// $_SERVER["REQUEST_URI"] = str_replace("/phalt/","/",$_SERVER["REQUEST_URI"]);
// $_GET["_url"] = "/";
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);
$loader->registerNamespaces(
    [
        'App\Components' => APP_PATH . '/components',
        'App\Listners' => APP_PATH . '/Listners'
    ]
);
$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);
//LOGGER--------------------------------Start-----------------------------------------------------
$adapter = new Stream('../storage/log/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);
$container->set(
    'logger',
    $logger
);
//LOGGER---------------------------End------------------------------------------------------------------
//EVENTMANAGER ------------------------------Start---------------------------------------------------------
$eventsManager = new EventsManager();
$eventsManager->attach(
    'NotificationListners',
    new \App\Listners\NotificationListners()
);
// $eventsManager->attach(
//     'db:afterQuery',$values = Setting::find('id = 1'),
//     $eventsManager = $this->di->get('EventsManager'),
//     $val = $eventsManager->fire('NotificationListners:checkzip', $user, $values),
//     function (Event $event, $connection) use ($logger) {
//         $logger->alert($connection->getSQLStatement());
//     }
// );
// $connection = new DbAdapter(
//     [
//         'host'     => 'mysql-server',
//         'username' => 'root',
//         'password' => 'secret',
//         'dbname'   => 'tutorial',
//     ]
// );
// $connection->setEventsManager($eventsManager);
// $connection->query(
//     'SELECT * FROM users'
// );
$container->set(
    'EventsManager',
    $eventsManager
);
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'mysql-server',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);




// $container->set(
//     'mongo',
//     function () {
//         $mongo = new MongoClient();

//         return $mongo->selectDB('phalt');
//     },
//     true
// );

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
