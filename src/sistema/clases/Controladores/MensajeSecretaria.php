<?php

/**
 * Puntos de entrada de vistas relacionadas con mensajes de Secretaría.
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

use Awsw\Gesi\Vistas\MensajeSecretaria\MensajeSecretariaInvList;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaInvCreate;

use Awsw\Gesi\Vistas\MensajeSecretaria\MensajeSecretariaSesList;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaSesCreate;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaSesRead;

use Awsw\Gesi\Vistas\MensajeSecretaria\MensajeSecretariaPsList;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaPsRead;

use Awsw\Gesi\Vistas\Vista;

class MensajeSecretaria extends Controlador
{

    public static function controla(): void
    {
        /**
         * Invitado.
         */
        
        parent::get('/inv/mensajesecretaria/', function () {
            Vista::dibuja(new MensajeSecretariaInvList());
        });
        
        // Create.
        parent::get('/inv/mensajesecretaria/create/', function () {
            (new MensajeSecretariaInvCreate(true))->manage();
        });
        parent::post('/inv/mensajesecretaria/create/', function () {
            (new MensajeSecretariaInvCreate(true))->manage();
        });

        /**
         * Sesión iniciada.
         */
        
        parent::get('/ses/secretaria/', function () {
            Vista::dibuja(new MensajeSecretariaSesList());
        });
        
        // Create.
        parent::get('/ses/mensajesecretaria/create/', function () {
            (new MensajeSecretariaSesCreate(true))->manage();
        });
        parent::post('/ses/mensajesecretaria/create/', function () {
            (new MensajeSecretariaSesCreate(true))->manage();
        });
        
        // Read.
        parent::get('/ses/mensajesecretaria/read/', function () {
            (new MensajeSecretariaSesRead(true))->manage();
        });

        /**
         * Personal de Secretaría.
         */
        
        parent::get('/ps/secretaria/', function () {
            Vista::dibuja(new MensajeSecretariaPsList());
        });
        
        // Read.
        parent::get('/ps/mensajesecretaria/read/', function () {
            (new MensajeSecretariaPsRead(true))->manage();
        });
    }
}

?>