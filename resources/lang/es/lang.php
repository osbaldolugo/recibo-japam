<?php

return [

 /*
  *  Constants
  */

  'nav-active-tickets'               => 'Tickets Activos',
  'nav-completed-tickets'            => 'Tickets Completos',

  // Tables
  'table-id'                         => '#',
  'table-subject'                    => 'Asunto',
  'table-owner'                      => 'Dueño',
  'table-status'                     => 'Estado',
  'table-last-updated'               => 'Última Actualización',
  'table-priority'                   => 'Prioridad',
  'table-agent'                      => 'Agente',
  'table-category'                   => 'Categoría',

  // Datatables
  'table-decimal'                    => '',
  'table-empty'                      => 'No hay datos en esta tabla',
  'table-info'                       => 'Mostrando _START_ a _END_ de _TOTAL_ entradas',
  'table-info-empty'                 => 'Mostrando 0 de 0 a 0 entradas',
  'table-info-filtered'              => '(filtrados de _MAX_ totales)',
  'table-info-postfix'               => '',
  'table-thousands'                  => ',',
  'table-length-menu'                => 'Mostrar _MENU_ entradas',
  'table-loading-results'            => 'Cargando...',
  'table-processing'                 => 'Procesando...',
  'table-search'                     => 'Buscar:',
  'table-zero-records'               => 'No hemos encontrado entradas que correspondan',
  'table-paginate-first'             => 'Primera',
  'table-paginate-last'              => 'Última',
  'table-paginate-next'              => 'Siguiente',
  'table-paginate-prev'              => 'Anterior',
  'table-aria-sort-asc'              => ': activar para ordernar por esta columna ascendentemente',
  'table-aria-sort-desc'             => ': activar para ordernar por esta columna descendentemente',

  'btn-back'                         => 'Regresar',
  'btn-cancel'                       => 'Cancelar', // NEW
  'btn-close'                        => 'Cerrar',
  'btn-delete'                       => 'Borrar',
  'btn-edit'                         => 'Editar',
  'btn-mark-complete'                => 'Marcar como Completo',
  'btn-submit'                       => 'Enviar',

  'agent'                            => 'Agente',
  'category'                         => 'Categoría',
  'colon'                            => ': ',
  'comments'                         => 'Comentarios',
  'created'                          => 'Creado',
  'description'                      => 'Descripción',
  'flash-x'                          => '×', // &times;
  'last-update'                      => 'Última Actualización',
  'no-replies'                       => 'Sin respuestas.',
  'owner'                            => 'Dueño',
  'priority'                         => 'Prioridad',
  'reopen-ticket'                    => 'Reabrir Ticket',
  'reply'                            => 'Responder',
  'responsible'                      => 'Responsable',
  'status'                           => 'Estado',
  'subject'                          => 'Asunto',

 /*
  *  Page specific
  */

// ____
  'index-title'                      => 'Soporte página principal',

// tickets/____
  'index-my-tickets'                 => 'Mis Tickets',
  'btn-create-new-ticket'            => 'Crear nuevo tiquet',
  'index-complete-none'              => 'No hay tiquets completados',
  'index-active-check'               => 'Asegúrate de revisar los Tickets Activos si no puedes encontrar el tiquet.',
  'index-active-none'                => 'No hay tiquets activos,',
  'index-create-new-ticket'          => 'Crear un tiquet nuevo',
  'index-complete-check'             => 'Asegúrate de revisar los Tickets Completados si no puedes encontrar el tiquet.',

  'create-ticket-title'              => 'Formulario de Nuevo Ticket',
  'create-new-ticket'                => 'Crear Nuevo Ticket',
  'create-ticket-brief-issue'        => 'Un resumen del problema que tienes',
  'create-ticket-describe-issue'     => 'Describe en detalle el problema que tienes',

  'show-ticket-title'                => 'Ticket',
  'show-ticket-js-delete'            => '¿Estás seguro que quieres borrar?: ',
  'show-ticket-modal-delete-title'   => 'Borrar Ticket',
  'show-ticket-modal-delete-message' => '¿Estás seguro que quieres borrar: :subject?',

 /*
  *  Controllers
  */

// AgentsController
  'agents-are-added-to-agents'                      => 'Agentes :names fueron añadidos a agentes',
  'administrators-are-added-to-administrators'      => 'Administradores :names fueron añadidos a administradores', //New
  'agents-joined-categories-ok'                     => 'Te agregaste a categorías',
  'agents-is-removed-from-team'                     => 'Eliminamos agente\s :name del equipo de agentes',
  'administrators-is-removed-from-team'             => 'Eliminamos administrador\es :name del equipo de administradores', // New

// CategoriesController
  'category-name-has-been-created'   => 'La categoría :name fue creada!',
  'category-name-has-been-modified'  => 'La cateogría :name fue modificada!',
  'category-name-has-been-deleted'   => 'La categoría :name fue borrada!',

// PrioritiesController
  'priority-name-has-been-created'   => 'La prioridad :name fue creada!',
  'priority-name-has-been-modified'  => 'La prioridad :name fue modificada!',
  'priority-name-has-been-deleted'   => 'La prioridad :name fue borrada!',
  'priority-all-tickets-here'        => 'Todos los tiquets relacionados a la cateogoría aquí',

// StatusesController
  'status-name-has-been-created'   => 'El estado :name fue creado!',
  'status-name-has-been-modified'  => 'El estado :name fue modificado!',
  'status-name-has-been-deleted'   => 'El estado :name fue borrado!',
  'status-all-tickets-here'        => 'Todos los tiquets relacionados al estado aquí',

// CommentsController
  'comment-has-been-added-ok'        => 'Su Comentario fue añadido de forma correcta',

// NotificationsController
  'notify-new-comment-from'          => 'Nuevo comentario de ',
  'notify-on'                        => ' en ',
  'notify-status-to-complete'        => ' estado a Completado ',
  'notify-status-to'                 => ' estado a ',
  'notify-transferred'               => ' transferido ',
  'notify-to-you'                    => ' a usted ',
  'notify-created-ticket'            => ' creó tiquet ',
  'notify-updated'                   => ' actualizado ',

 // TicketsController
  'the-ticket-has-been-created'      => 'El tiquet fue creado!',
  'the-ticket-has-been-modified'     => 'El tiquet fue modificado!',
  'the-ticket-has-been-deleted'      => 'El tiquet :name fue borrado!',
  'the-ticket-has-been-completed'    => 'El tiquet :name fue completado!',
  'the-ticket-has-been-reopened'     => 'El tiquet :name fue reabierto!',
  'you-are-not-permitted-to-do-this' => 'No tienes los permisos necesarios para realizar esta acción!',

 /*
 *  Middlewares
 */

 //  IsAdminMiddleware IsAgentMiddleware ResAccessMiddleware
  'you-are-not-permitted-to-access'     => 'No tienes los permisos necesarios para accesar a esta página!',

];
