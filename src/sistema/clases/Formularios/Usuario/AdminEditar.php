<?php

/**
 * Gesión del formulario de edición de un Usuario.
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

namespace Awsw\Gesi\Formularios\Usuario;

use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Formularios\Valido;

class AdminEditar extends Formulario
{   
    private $usuario;
    private $id;

    public function __construct(string $action, Usuario $usuario) {
        parent::__construct('form-usuario-editar', array('action' => $action));
        $this->usuario = $usuario;
        $this->id = $this->usuario->getId();
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {

        $rol = isset($datos_iniciales['rol']) ?
            $datos_iniciales['rol'] : $this->usuario->getRol();

        $rol_options = '';
        foreach (Valido::getRoles() as $raw => $valor) {
            $selected = $raw == $rol ? ' selected="selected"' : '';
            $rol_nombre = $valor['rol'];
    
            $rol_options .= <<< HTML
            <option value="$raw" $selected>$rol_nombre</option>
            
            HTML;
        }

        $nif = isset($datos_iniciales['nif']) ?
            $datos_iniciales['nif'] : $this->usuario->getNif();

        $nombre = isset($datos_iniciales['nombre']) ?
            $datos_iniciales['nombre'] : $this->usuario->getNombre();

        $apellidos = isset($datos_iniciales['apellidos']) ?
            $datos_iniciales['apellidos'] : $this->usuario->getApellidos();

        $fecha_nacimiento = isset($datos_iniciales['fecha_nacimiento']) ? 
            $datos_iniciales['fecha_nacimiento'] : strftime("%e/%m/%Y", $this->usuario->getFechaNacimiento());

        $numero_telefono = isset($datos_iniciales['numero_telefono']) ? 
            $datos_iniciales['numero_telefono'] : $this->usuario->getNumeroTelefono();

        $email = isset($datos_iniciales['email']) ?
            $datos_iniciales['email'] : $this->usuario->getEmail();

        $grupo = isset($datos_iniciales['grupo']) ?
            $datos_iniciales['grupo'] : $this->usuario->getGrupo();

        $grupo_options = '';
        foreach (Grupo::dbGetAll() as $g) {
            $id = $g->getId();
            $selected = $id == $grupo ? ' selected="selected"' : '';
            $grupo_nombre = $g->getNombreCompleto();
    
            $grupo_options .= <<< HTML
        <option value="$id" $selected>$grupo_nombre</option>
        
        HTML;
        }

        $this->html .= <<< HTML
        <div class="form-group">
            <label for="nif">NIF</label>
            <input class="form-control" type="text" name="nif" id="nif" value="$nif" placeholder="NIF" required="required" />
        </div>
        
        <div class="form-group">
            <label for="rol">Rol</label>
            <select class="form-control" name="rol" id="rol", required="required">
                $rol_options
            </select>
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" value="$nombre" placeholder="Nombre" required="required" />
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" value="$apellidos" placeholder="Apellidos" required="required" />
        </div>
        
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="$fecha_nacimiento" placeholder="Fecha de nacimiento" required="required" />
        </div>
        
        <div class="form-group">
            <label for="numero_telefono">Número de teléfono</label>
            <input class="form-control" type="text" name="numero_telefono" id="numero_telefono" value="$numero_telefono" placeholder="Número de teléfono" required="required" />
        </div>
        
        <div class="form-group">
            <label for="email">Dirección de correo electrónico</label>
            <input class="form-control" type="text" name="email" id="email" value="$email" placeholder="Dirección de correo electrónico" required="required" />
        </div>
        
        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select class="form-control" name="grupo" id="grupo", required="required">
                $grupo_options
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn">Actualizar</button>
        </div>

        HTML;

    }

    protected function procesa(array & $datos) : void
    {
        $nif = isset($datos['nif']) ? $datos['nif'] : null;

        $rol = isset($datos['rol']) ? $datos['rol'] : null;

        $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;

        $apellidos = isset($datos['apellidos']) ? $datos['apellidos'] : null;

        $fecha_nacimiento = isset($datos['fecha_nacimiento']) ?
            $datos['fecha_nacimiento'] : null;

        $numero_telefono = isset($datos['numero_telefono']) ?
            $datos['numero_telefono'] : null;

        $email = isset($datos['email']) ? $datos['email'] : null;

        $grupo = isset($datos['grupo']) ? $datos['grupo'] : null;

        if (empty($nif)) {
            Vista::encolaMensajeError('El campo NIF no puede estar vacío.');
        }

        if (empty($nombre)) {
            Vista::encolaMensajeError('El campo nombre no puede estar vacío.');
        } elseif (! Valido::testStdString($nombre)) {
            Vista::encolaMensajeError('El campo nombre no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.');
        }

        if (empty($apellidos)) {
            Vista::encolaMensajeError('El campo apellidos no puede estar vacío.');
        } elseif (! Valido::testStdString($apellidos)) {
            Vista::encolaMensajeError('El campo apellidos no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.');
        }

        if (empty($fecha_nacimiento)) {
            Vista::encolaMensajeError('El campo fecha de nacimiento no puede estar vacío.');
        } elseif (! Valido::testDate($fecha_nacimiento)) {
            Vista::encolaMensajeError('El campo fecha de nacimiento no es válido. El formato debe ser dd/mm/yyyy.');
        } else {
            $format = 'd/m/Y';
            $d = \DateTime::createFromFormat($format, $fecha_nacimiento);
            $fecha_nacimiento = $d->getTimestamp();
        }

        if (empty($numero_telefono)) {
            Vista::encolaMensajeError('El campo número de teléfono no puede estar vacío.');
        } elseif (! Valido::testNumeroTelefono($numero_telefono)) {
            Vista::encolaMensajeError('El campo número de teléfono no es válido.');
        }

        if (empty($email)) {
            Vista::encolaMensajeError('El campo dirección de correo electrónico no puede estar vacío.');
        } elseif (! Valido::testEmail($email)) {
            Vista::encolaMensajeError('El campo dirección de correo electrónico no es válido.');
        }

        /*
         * Comprobar que el rol no está vacío y que es un valor admitido.
         * 
         * TODO: log si pasa algo que no nos gusta
         */

        if (empty($rol) || ! Valido::testRolRaw($rol)) {
            Vista::encolaMensajeError('El campo rol no es válido.');
        }

        /*
         * Comprobar que el grupo no está vacío y que es un valor admitido.
         * 
         * TODO: log si pasa algo que no nos gusta
         */

        if (empty($grupo) || ! Grupo::dbExisteId($grupo)) {
            Vista::encolaMensajeError('El campo grupo no es válido.');
        }

        // Si no hay ningún error, continuar.
        if (! Vista::hayMensajesError()) {

            $usuario = new Usuario(
                $this->usuario->getId(),
                $nif,
                $rol,
                $nombre,
                $apellidos,
                $fecha_nacimiento,
                $numero_telefono,
                $email,
                $this->usuario->getFechaUltimoAcceso(),
                $this->usuario->getFechaRegistro(),
                $grupo
            );

            $actualizar = $usuario->dbActualizar();

            if ($actualizar) {
                Vista::encolaMensajeExito('Usuario actualizado correctamente.', "/admin/usuarios/$this->id/ver/");
            } else {
                Vista::encolaMensajeError('Hubo un error al actualizar el usuario.');
            }
        }

        $this->genera($datos);
 
    }
}