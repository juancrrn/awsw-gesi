<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con asignacion.
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

use Awsw\Gesi\Vistas\Asignacion\AsignacionPsList;
use Awsw\Gesi\Vistas\Asignacion\AsignacionEstList;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsCreate;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsDelete;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsRead;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsUpdate;
use Awsw\Gesi\Vistas\Asignacion\AsignacionEstHorario;
use Awsw\Gesi\Vistas\Asignacion\AsignacionPdHorario;
use Awsw\Gesi\Vistas\Asignacion\AsignacionPdList;

use Awsw\Gesi\Vistas\Vista;

class Asignacion extends Controlador
{

    public static function controla(): void
    {

        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/asignaciones/', function () {
            Vista::dibuja(new AsignacionPsList());
        });

        // Create.
        parent::get('/ps/asignacion/create/', function () {
            (new AsignacionPsCreate(true))->manage();
        });
        parent::post('/ps/asignacion/create/', function () {
            (new AsignacionPsCreate(true))->manage();
        });

        // Read.
        parent::get('/ps/asignacion/read/', function () {
            (new AsignacionPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/asignacion/update/', function () {
            (new AsignacionPsUpdate(true))->manage();
        });
        parent::patch('/ps/asignacion/update/', function () {
            (new AsignacionPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/asignacion/delete/', function () {
            (new AsignacionPsDelete(true))->manage();
        });
        parent::delete('/ps/asignacion/delete/', function () {
            (new AsignacionPsDelete(true))->manage();
        });

        /**
         * Personal Docente
         */
        
        parent::get('/pd/asignaciones/', function() {
            Vista::dibuja(new AsignacionPdList());
        });

        parent::get('/pd/asignaciones/horario/', function () {
            Vista::dibuja(new AsignacionPdHorario());
        });

        /**
         * Estudiante.
         */

        parent::get('/est/asignaciones/', function () {
            Vista::dibuja(new AsignacionEstList());
        });

        parent::get('/est/asignaciones/horario/', function () {
            Vista::dibuja(new AsignacionEstHorario());
        });
    }
}

?>