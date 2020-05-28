<?php 

/**
 * Vista de perfil de un usuario en particular.
 *
 * - Cualquier usuario con sesión puede acceder.
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
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;

class SesionPerfil extends Modelo
{

    private const VISTA_NOMBRE = "Mi perfil ";
    private const VISTA_ID = "mi-perfil";

    private $usuario;

    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->usuario = Sesion::getUsuarioEnSesion();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {
        $nombre_completo = $this->usuario->getNombreCompleto();

        $nif = $this->usuario->getNif();

        switch ($this->usuario->getRol()) {
            case 1: $rol = 'Estudiante'; break;
            case 2: $rol = 'Personal docente'; break;
            case 3: $rol = 'Personal de Secretaría'; break;
        }

        $fecha_nacimiento = date("d/m/Y", $this->usuario->getFechaNacimiento());
        $numero_telefono = $this->usuario->getNumeroTelefono();
        $email = $this->usuario->getEmail();
        $fecha_ultimo_acceso = date("d/m/Y", $this->usuario->getFechaUltimoAcceso());
        $fecha_registro = date("d/m/Y", $this->usuario->getFechaRegistro());
        
        $lista_grupo = $this->generaGrupo();

        $html = <<< HTML
        <header class ="page-header">
            <h1>$nombre_completo</h1>
        </header>
        <section class="page-content">
            <div class="data-field-wrapper">
                <div class="data-field">
                    <span class="label">NIF</span>
                    <span class="value">$nif</span>
                </div>
                <div class="data-field">
                    <span class="label">Fecha nacimiento</span>
                    <span class="value">$fecha_nacimiento</span>
                </div>
                <div class="data-field">
                    <span class="label">Número de teléfono</span>
                    <span class="value">$numero_telefono</span>
                </div>
                <div class="data-field">
                    <span class="label">Dirección de correo electrónico</span>
                    <span class="value">$email</span>
                </div>
            </div>
            <h2>Grupo</h2>
            <div id="usuario-admin-ver-grupo-lista" class="grid-table">
                <div class="grid-table-header">
                    <div class="grid-table-row">
                        <div></div>
                        <div>Nombre</div>
                        <div>Nivel</div>
                    </div>
                </div>
                <div class="grid-table-body">
                    $lista_grupo
                </div>
            </div>
        </section>
        HTML;

        echo $html;

    }

    public function generaGrupo() : string
    {
        $grupo_id = $this->usuario->getGrupo();

        $html = '';

        if ($grupo_id) {
            $grupo = Grupo::dbGet($grupo_id);
            $completo = $grupo->getNombreCompleto();
            $corto = $grupo->getNombreCorto();
            $nivel = $grupo->getNivel();

            $html .= <<< HTML
            <div class="grid-table-row">
                <div>$corto</div>
                <div>$completo</div>
                <div>$nivel</div>
            </div>

HTML;
        } else {
            $html = <<< HTML
            <div class="grid-table-row-empty">
                Este usuario no está matriculado en ningún grupo.
            </div>

HTML;
        }

        return $html;
    }
}

?>