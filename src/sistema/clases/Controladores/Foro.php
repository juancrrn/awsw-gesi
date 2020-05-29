<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con foros.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\FormulariosAjax\Foro\ForoPsCreate;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsDelete;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsRead;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsUpdate;
use Awsw\Gesi\Vistas\Foro\ForoPsList;
use Awsw\Gesi\Vistas\Foro\MensajeForoEstList;
use Awsw\Gesi\Vistas\Vista;

class Foro extends Controlador
{

    public static function controla(): void
    {

        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/foros/', function () {
            Vista::dibuja(new ForoPsList());
        });

        // Create.
        parent::get('/ps/foros/create/', function () {
            (new ForoPsCreate(true))->manage();
        });
        parent::post('/ps/foros/create/', function () {
            (new ForoPsCreate(true))->manage();
        });

        // Read.
        parent::get('/ps/foros/read/', function () {
            (new ForoPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/foros/update/', function () {
            (new ForoPsUpdate(true))->manage();
        });
        parent::patch('/ps/foros/update/', function () {
            (new ForoPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/foros/delete/', function () {
            (new ForoPsDelete(true))->manage();
        });
        parent::delete('/ps/foros/delete/', function () {
            (new ForoPsDelete(true))->manage();
        });
        
        /**
         * Estudiante.
         */

        parent::get('/est/foros/([0-9]+)/', function ($foroId) {
            Vista::dibuja(new MensajeForoEstList($foroId));
        });
    }
}

?>