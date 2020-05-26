<?php

/**
 * Autoconfiguración de JavaScript.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

use Awsw\Gesi\App;

require_once __DIR__ . "/../sistema/configuracion.php";

$app = App::getSingleton();

$appUrl = $app->getUrl();
$appName = $app->getNombre();
$appProduction = (! $app->isDesarrollo()) ? 'true' : 'false';

$js = <<< JS

/**
 * Autoconfigure JavaScript based in PHP application configuration
 *
 * @package php-ajax-form-demo
 *
 * @author Juan Carrión
 *
 * @version 0.0.1
 */

var autoconf = {
    APP_URL : "$appUrl",
    APP_NAME : "$appName",
    APP_PRODUCTION : $appProduction
}

JS;

header('Content-Type: application/javascript; charset=utf-8');

echo $js;

die();

?>