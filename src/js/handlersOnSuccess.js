/**
 * Handlers de eventos on-success de formularios AJAX.
 * 
 * Usando el símbolo $ para variables de tipo objeto de jQuery.
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

/**
 * jQuery on document ready
 */
$(() => {

    /*
     *
     * Usuarios.
     * 
     */

    $('#usuario-est-lista').on('created.usuario.est',
        onSuccessFn.listaUsuariosEstCreated);
    $('#usuario-est-lista').on('updated.usuario.est',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-est-lista').on('deleted.usuario.est',
        onSuccessFn.listaUsuariosDeleted);
    $('#usuario-pd-lista').on('created.usuario.pd',
        onSuccessFn.listaUsuariosPdCreated);
    $('#usuario-pd-lista').on('updated.usuario.pd',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-pd-lista').on('deleted.usuario.pd',
        onSuccessFn.listaUsuariosDeleted);
    $('#usuario-ps-lista').on('created.usuario.ps',
        onSuccessFn.listaUsuariosPsCreated);
    $('#usuario-ps-lista').on('updated.usuario.ps',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-ps-lista').on('deleted.usuario.ps',
        onSuccessFn.listaUsuariosDeleted);

    /*
     *
     * Asignaciones.
     * 
     */

    $('#asignacion-ps-list').on('created.asignacion',
        onSuccessFn.listaPsAsignacionesCreated);
    $('#asignacion-ps-list').on('updated.asignacion',
        onSuccessFn.listaPsAsignacionesUpdated);
    $('#asignacion-ps-list').on('deleted.asignacion',
        onSuccessFn.listaPsAsignacionesDeleted);

    /*
     *
     * Mensajes de Secretaría.
     * 
     */

    $('#mensaje-secretaria-ses-list').on('created.ses.mensajesecretaria',
        onSuccessFn.listaSesMensajesSecretariaCreated);

    /*
     *
     * Asignaturas.
     * 
     */

    $('#asignatura-ps-list').on('created.asignatura',
        onSuccessFn.listaPsAsignaturasCreated);
    $('#asignatura-ps-list').on('updated.asignatura',
        onSuccessFn.listaPsAsignaturasUpdated);
    $('#asignatura-ps-list').on('deleted.asignatura',
        onSuccessFn.listaPsAsignaturasDeleted);

    /*
     *
     * Grupos.
     * 
     */

    $('#grupo-ps-list').on('created.grupo.ps',
        onSuccessFn.listaGruposPsCreated);
    $('#grupo-ps-list').on('updated.grupo.ps',
        onSuccessFn.listaGruposPsUpdated);
    $('#grupo-ps-list').on('deleted.grupo.ps',
        onSuccessFn.listaGruposPsDeleted);  

    /*
     *
     * Eventos.
     * 
     */

    $('#evento-ps-lista').on('created.evento.ps',
    onSuccessFn.listaEventoPsCreated);
    $('#evento-ps-lista').on('updated.evento.ps',
    onSuccessFn.listaEventoPsUpdated);
    $('#evento-ps-lista').on('deleted.evento.ps',
    onSuccessFn.listaEventoPsDeleted);  

    /*
     *
     * Foros.
     * 
     */

    $('#foro-ps-list').on('created.foro.ps',
        onSuccessFn.listaPsForosCreated);
    $('#foro-ps-list').on('updated.foro.ps',
        onSuccessFn.listaPsForosUpdated);
    $('#foro-ps-list').on('deleted.foro.ps',
        onSuccessFn.listaPsForosDeleted);

    /*
     *
     * Mensajes principales de foros.
     * 
     */

    $('#mensaje-foro-ses-list').on('created.mensajeforo.ses',
        onSuccessFn.listaMensajeForoCreated);
});