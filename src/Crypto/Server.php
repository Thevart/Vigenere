<?php
/**
 * Created by PhpStorm.
 * User: thevart
 * Date: 08/12/14
 * Time: 18:10
 */

namespace Crypto;

use Silex\Application;
use Silex\ControllerProviderInterface;

class Server implements ControllerProviderInterface{
    public function setup(Application $app){

    }
    public function connect(Application $app){
        $routing = $app['controllers_factory'];

        /* Set corresponding endpoints on the controller classes */
        Controller\MainController::addRoutes($routing);

        return $routing;
    }

} 