<?php

/**
 * Pie HTML (append).
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
 * @version 0.0.4
 */

use Awsw\Gesi\App;

$app = App::getSingleton();

$appUrl = $app->getUrl();

$v = (! $app->isDesarrollo()) ? '' : '?v=0.0.0' . time();

$appUrl = $app->getUrl();
$appName = $app->getNombre();
$appProduction = (! $app->isDesarrollo()) ? 'true' : 'false';
$scheduleTimeStartLimit = $app->getScheduleTimeStartLimit();
$scheduleTimeEndLimit = $app->getScheduleTimeEndLimit();
$scheduleDayValid = $app->getScheduleDayValid();

$jsAutoconf = <<< JS
var autoconf = {
    APP_URL : "$appUrl",
    APP_NAME : "$appName",
    APP_PRODUCTION : $appProduction,
    GESI_SCHEDULE_TIME_START_LIMIT : "$scheduleTimeStartLimit",
    GESI_SCHEDULE_TIME_END_LIMIT : "$scheduleTimeEndLimit",
    GESI_SCHEDULE_DAY_VALID : "$scheduleDayValid"
}
JS;

$footerFinalHtmlBuffer = <<< HTML
        <footer id="main-footer" class="page-footer font-small bg-light pt-4">
            <div class="footer-copyright text-center p-3">
                <p>© 2020 Gesi</p>
                <p>Versión 0.0.4</p>
            </div>
        </footer>

        <!-- Autoconfiguration de la aplicación -->
        <script>
            $jsAutoconf
        </script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

        <!-- Popper -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <!-- Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        <!-- Scripts de la aplicación -->
        <script src="$appUrl/js/auxfn.js$v"></script>
        <script src="$appUrl/js/toast.js$v"></script>
        <script src="$appUrl/js/app.js$v"></script>
        <script src="$appUrl/js/formulariosAjax.js$v"></script>
        <script src="$appUrl/js/funcionesOnSuccess.js$v"></script>
        <script src="$appUrl/js/handlersOnSuccess.js$v"></script>
        <script src="$appUrl/js/gesiSchedule.js$v"></script>
    </body>
</html>
HTML;

echo $footerFinalHtmlBuffer;

?>