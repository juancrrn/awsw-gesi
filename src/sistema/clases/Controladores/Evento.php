<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con eventos.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Vista;

use Awsw\Gesi\Vistas\Evento\EventoInvList;
use Awsw\Gesi\Vistas\Evento\EventoPsList;

use Awsw\Gesi\FormulariosAjax\Evento\EventoPsCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsDelete;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsRead;

class Evento extends Controlador
{

    public static function controla(): void
    {
        /**
         * Invitado.
         */
        
        parent::get('/inv/eventos/', function () {
            Vista::dibuja(new EventoInvList());
        });


        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/eventos/', function () {
            Vista::dibuja(new EventoPsList());
        });

        // Create.
        parent::get('/ps/eventos/create/', function () {
            (new EventoPsCreate(true))->manage();
        });
        parent::post('/ps/eventos/create/', function () {
            (new EventoPsCreate(true))->manage();
        });
        
        // Read.
        parent::get('/ps/eventos/read/', function () {
            (new EventoPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/eventos/update/', function(){
            (new EventoPsUpdate(true))->manage();
        });
        parent::patch('/ps/eventos/update/', function(){
            (new EventoPsUpdate(true))->manage();
        });

        // Delete.
         parent::get('/ps/eventos/delete/', function(){
            (new EventoPsDelete(true))->manage();
        });
        parent::delete('/ps/eventos/delete/', function(){
            (new EventoPsDelete(true))->manage();
        });
    }
}

?>