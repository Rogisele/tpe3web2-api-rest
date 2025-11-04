<?php
require_once './libs/router.php';
require_once './app/Apicontrollers/chapters.api.controller.php';
require_once './app/Apicontrollers/seasons.api.controller.php';
require_once './app/Apicontrollers/user.api.controller.php';

// crea el router
$router = new Router();


// define la tabla de ruteo
    #              endpoint ,  verbo ,     controller  ,       metodo

$router->addRoute('season', 'GET', 'SeasonController', 'getAll');
$router->addRoute('season', 'POST', 'SeasonController', 'addSeason');
$router->addRoute('season/:id', 'PUT', 'SeasonController', 'updateSeason');
$router->addRoute('season/:id', 'GET', 'SeasonController', 'listCategoriesById');
$router->addRoute('season/:id', 'DELETE', 'SeasonController', 'deleteSeason');

/*$router->addRoute('usuarios/token', 'GET', 'UserApiController',   'getToken');*/

$router->addRoute('chapters', 'GET', 'ChaptersController', 'getAll');
$router->addRoute('chapter', 'POST', 'ChaptersController', 'add');
$router->addRoute('chapter/:id', 'GET', 'ChaptersController', 'getById');
$router->addRoute('chapter/:id', 'PUT', 'ChaptersController', 'update');
$router->addRoute('chapter/:id', 'DELETE', 'ChaptersController', 'delete');
// rutea
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>