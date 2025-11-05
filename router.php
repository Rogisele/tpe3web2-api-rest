<?php
require_once './libs/router.php';
require_once './app/Apicontrollers/chapter.api.controller.php';
require_once './app/Apicontrollers/season.api.controller.php';
require_once './app/Apicontrollers/user.api.controller.php';

// crea el router
$router = new Router();

// definimos la tabla de ruteo
#                  endpoint       verbo     controlador         método

// Temporadas
$router->addRoute('season', 'GET', 'SeasonController', 'getAll'); // o 'listCategories'
$router->addRoute('season', 'POST', 'SeasonController', 'addSeason');
$router->addRoute('season/:id', 'PUT', 'SeasonController', 'updateSeason');
$router->addRoute('season/:id', 'GET', 'SeasonController', 'listCategoriesById');
$router->addRoute('season/:id', 'DELETE', 'SeasonController', 'deleteSeason');

// Capítulos
$router->addRoute('chapters', 'GET', 'ChapterController', 'getAll');
$router->addRoute('chapter', 'POST', 'ChapterController', 'add');
$router->addRoute('chapter/:id', 'GET', 'ChapterController', 'getById');
$router->addRoute('chapter/:id', 'PUT', 'ChapterController', 'update');
$router->addRoute('chapter/:id', 'DELETE', 'ChapterController', 'delete');

// Usuarios (opcional para login/token)
$router->addRoute('login', 'POST', 'UserApiController', 'login'); // si implementás login

// rutea
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>
