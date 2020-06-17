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
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Vistas\Evento\EventoEstList;

use Awsw\Gesi\Vistas\Evento\EventoPdList;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdDelete;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdRead;


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
            Vista::dibuja(new EventoEstList());
        });

        /**
         * Personal docente.
         */

        parent::get('/pd/eventos/', function () {
            Vista::dibuja(new EventoPdList());
        });

        // Create.
        parent::get('/pd/eventos/create/', function () {
            (new EventoPdCreate(true))->manage();
        });
        parent::post('/pd/eventos/create/', function () {
            (new EventoPdCreate(true))->manage();
        });
        
        // Read.
        parent::get('/pd/eventos/read/', function () {
            (new EventoPdRead(true))->manage();
        });

        // Update.
        parent::get('/pd/eventos/update/', function(){
            (new EventoPdUpdate(true))->manage();
        });
        parent::patch('/pd/eventos/update/', function(){
            (new EventoPdUpdate(true))->manage();
        });

        // Delete.
           parent::get('/pd/eventos/delete/', function(){
            (new EventoPdDelete(true))->manage();
        });
        parent::delete('/pd/eventos/delete/', function(){
            (new EventoPdDelete(true))->manage();
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
        parent::get('/pd/eventos/update/', function(){
            (new EventoPdUpdate(true))->manage();
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