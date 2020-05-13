<?php

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once("functions.php");
require_once("site.php");
require_once("usuario.php");
require_once("animal.php");
require_once("perdido.php");
require_once("achado.php");
require_once("doacao.php");
require_once("recomendacao.php");

$app->run();

?>