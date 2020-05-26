<?php

/**
 * Gesión del formulario de creación de usuario.
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

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Vistas\Vista;

class AdminCrear extends Formulario
{
    public function __construct(string $action) {
        parent::__construct('form-usuario-crear', array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {

        $nif = isset($datos_iniciales['nif']) ?
            $datos_iniciales['nif'] : '';

        $nombre = isset($datos_iniciales['nombre']) ?
            $datos_iniciales['nombre'] : '';

        $apellidos = isset($datos_iniciales['apellidos']) ?
            $datos_iniciales['apellidos'] : '';

        $fecha_nacimiento = isset($datos_iniciales['fecha_nacimiento']) ? 
            $datos_iniciales['fecha_nacimiento'] : '';

        $numero_telefono = isset($datos_iniciales['numero_telefono']) ? 
            $datos_iniciales['numero_telefono'] : '';

        $email = isset($datos_iniciales['email']) ?
            $datos_iniciales['email'] : '';

        $this->html .= <<< HTML
<div class="form-group">
    <label for="nif">NIF</label>
    <input class="form-control" type="text" name="nif" id="nif" value="$nif" placeholder="NIF" required="required" />
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
    <label for="tipo">Tipo</label>
    <select class="form-control" name="tipo" id="tipo" required="required">
        <option value="" selected disabled>Selecciona...</option>
        <option value="1">Estudiante</option>
        <option value="2">Personal docente</option>
        <option value="3">Personal de Secretaría</option>
    </select>
</div>

<div class="form-actions">
    <button type="submit" class="btn">Crear</button>
</div>

HTML;

    }

    protected function procesa(array & $datos) : void
    {

        $nif = $datos['nif'] ?? null;
        $nombre = $datos['nombre'] ?? null;
        $apellidos = $datos['apellidos'] ?? null;
        $fecha_nacimiento = $datos['fecha_nacimiento'] ?? null;
        $numero_telefono = $datos['numero_telefono'] ?? null;
        $email = $datos['email'] ?? null;
        $tipo = $datos['tipo'] ?? null;

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
         * Comprobar que el tipo no está vacío y que es un valor admitido.
         * 
         * TODO: log si pasa algo que no nos gusta
         */

        if (empty($tipo) || ! Valido::testTipoRaw($tipo)) {
            Vista::encolaMensajeError('El campo tipo no es válido.');
        }

        // Si no hay ningún error, continuar.
        if (! Vista::hayMensajesError()) {

            $now = time();

            $usuario = new Usuario(
                null,
                $nif,
                $tipo,
                $nombre,
                $apellidos,
                $fecha_nacimiento,
                $numero_telefono,
                $email,
                null,
                $now,
                null
            );

            $usuario_id = $usuario->dbInsertar();

            if ($usuario_id) {
                Vista::encolaMensajeExito('Usuario creado correctamente.', "/admin/usuarios/$usuario_id/ver/");
            } else {
                Vista::encolaMensajeError('Hubo un error al crear el usuario.');
            }

        }

        $this->genera($datos);

    }
}

?>