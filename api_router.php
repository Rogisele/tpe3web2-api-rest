<?php
// Carga de clases necesarias
require_once './libs/router.php';
require_once './app/Apicontrollers/chapters.api.controller.php';
require_once './app/Apicontrollers/seasons.api.controller.php';
require_once './app/Apicontrollers/user.api.controller.php';

// Instancia del router
$router = new Router();

// 📦 Tabla de ruteo

// 🗂️ Temporadas
$router->addRoute('season', 'GET', 'SeasonController', 'getAll');
$router->addRoute('season', 'POST', 'SeasonController', 'addSeason');
$router->addRoute('season/:id', 'PUT', 'SeasonController', 'updateSeason');
$router->addRoute('season/:id', 'GET', 'SeasonController', 'listCategoriesById');
$router->addRoute('season/:id', 'DELETE', 'SeasonController', 'deleteSeason');

// 🎬 Capítulos
$router->addRoute('chapters', 'GET', 'ChapterController', 'getAll');
$router->addRoute('chapter', 'POST', 'ChapterController', 'add');
$router->addRoute('chapter/:id', 'GET', 'ChapterController', 'getById');
$router->addRoute('chapter/:id', 'PUT', 'ChapterController', 'update');
$router->addRoute('chapter/:id', 'DELETE', 'ChapterController', 'delete');

// 👤 Usuarios (público)
$router->addRoute('login', 'POST', 'UserApiController', 'login');

// 🚀 Ejecución del router
$resource = $_GET['resource'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$router->route($resource, $method);