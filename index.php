<?php

require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(CONF_URL_SITE);

/**
 * Controllers namespace
 */
$router->namespace("Source\App");


/**
 * home
 */

$router->group(null);
$router->get("/", "Web:home", "web.home");


$router->get("/hasFlash", "Web:hasFlash", "web.flash");

/*
 * auth
 */
$router->group("/auth");
$router->get("/", "Web:login", "web.login");
$router->get("/cadastrar", "Web:addUser", "web.cad.user");
$router->post("/autenticar", "Web:authenticate", "web.authenticate");
$router->post("/logoff", "Web:logoff", "web.logoff");




/**
 * Relatórios
 */
$router->group("/relatorios");
$router->get("/orcamentos", "Web:budgetReport", "relatorio.orcamento");

// ajax
$router->group("/api_relatorios");
$router->get("/chartOrcamento", "Web:chatsOrcamentos", "chart.orcamento");


/**
 * TESTES
 */

$router->group("/testes");
$router->get("/orcamento", "Web:testeOrcamento", "teste.orcamento");

/**
 * ERRORS
 */
$router->group("whoops");
$router->get("/{errcode}", "Web:error");


/**
 * Executa as rotas
 */
$router->dispatch();

/**
 * Tratamento de erros de rotas
 */
if ($router->error()) {
    $router->redirect("/whoops/{$router->error()}");
}
