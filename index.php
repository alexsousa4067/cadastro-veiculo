<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

use Source\Core\Session;
use CoffeeCode\Router\Router;

$session = new Session();
$route = new Router(url(), ":");

/*
 * WEB ROUTES
 */
$route->namespace("Source\App");
$route->get("/", "Web:home",);
$route->get("/cadastrar-veiculo", "Web:createVehicle");
$route->post("/cadastrar-veiculo", "Web:storeVehicle");
$route->get("/editar-veiculo/{vehicle_id}", "Web:editVehicle");
$route->post("/editar-veiculo/{vehicle_id}", "Web:updateVehicle");
$route->get("/excluir-veiculo/{vehicle_id}", "Web:deleteVehicle");
$route->post("/pesquisar", "Web:search");

/*
 * ERROR ROUTES
 */
$route->namespace("Source\App")->group("/ops");
$route->get("/{errcode}", "Web:error");

/*
 * ROUTE
 */
$route->dispatch();

/*
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
