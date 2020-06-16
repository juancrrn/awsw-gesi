<?php

/**
 * Autoconfiguración de JavaScript.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

use Awsw\Gesi\App;

require_once __DIR__ . "/../sistema/configuracion.php";

$app = App::getSingleton();

$appUrl = $app->getUrl();
$appName = $app->getNombre();
$appProduction = (! $app->isDesarrollo()) ? 'true' : 'false';
$scheduleTimeStartLimit = $app->getScheduleTimeStartLimit();
$scheduleTimeEndLimit = $app->getScheduleTimeEndLimit();
$scheduleDayValid = $app->getScheduleDayValid();

$js = <<< JS

/**
 * Autoconfiguración de JavaScript.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

var autoconf = {
    APP_URL : "$appUrl",
    APP_NAME : "$appName",
    APP_PRODUCTION : $appProduction,
    GESI_SCHEDULE_TIME_START_LIMIT : "$scheduleTimeStartLimit",
    GESI_SCHEDULE_TIME_END_LIMIT : "$scheduleTimeEndLimit",
    GESI_SCHEDULE_DAY_VALID : "$scheduleDayValid"
}

JS;

header('Content-Type: application/javascript; charset=utf-8');

echo $js;

die();

?>