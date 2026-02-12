<?php

return [

 /*
  *  Constants
  */
  'nav-settings'                  => 'Configuración',
  'nav-agents'                    => 'Agentes',
  'nav-dashboard'                 => 'Dashboard',
  'nav-categories'                => 'Categorías',
  'nav-priorities'                => 'Prioridades',
  'nav-statuses'                  => 'Estados',
  'nav-configuration'             => 'Configuración',
  'nav-administrator'             => 'Administrador',  //new

  'table-hash'                    => '#',
  'table-id'                      => 'ID',
  'table-name'                    => 'Nombre',
  'table-action'                  => 'Acción',
  'table-categories'              => 'Categorías',
  'table-join-category'           => 'Categorías Unidas',
  'table-remove-agent'            => 'Eliminar agentes',
  'table-remove-administrator'    => 'Eliminar administradores', // New

  'table-slug'                    => 'Código',
  'table-default'                 => 'Valor Predeterminado',
  'table-value'                   => 'Mi Valor',
  'table-lang'                    => 'Idioma',
  'table-edit'                    => 'Editar',

  'btn-back'                      => 'Atrás',
  'btn-delete'                    => 'Borrar',
  'btn-edit'                      => 'Editar',
  'btn-join'                      => 'Unir',
  'btn-remove'                    => 'Eliminar',
  'btn-submit'                    => 'Enviar',
  'btn-save'                      => 'Salvar',
  'btn-update'                    => 'Actualizar',

  'colon'                         => ': ',

 /*
  *  Page specific
  */

// tickets-admin/____
  'index-title'                         => 'Dashboard del sistema de tiquets',
  'index-empty-records'                 => 'Todavía no hay entradas',
  'index-total-tickets'                 => 'Total de tiquets',
  'index-open-tickets'                  => 'Tiquets abiertos',
  'index-closed-tickets'                => 'Tiquets cerrados',
  'index-performance-indicator'         => 'Indicador de rendimiento',
  'index-periods'                       => 'Periodos',
  'index-3-months'                      => '3 meses',
  'index-6-months'                      => '6 meses',
  'index-12-months'                     => '12 meses',
  'index-tickets-share-per-category'    => 'Tiquets compartidos por categoría',
  'index-tickets-share-per-agent'       => 'Tiquets compartidos por agente',
  'index-categories'                    => 'Categorías',
  'index-category'                      => 'Categoría',
  'index-agents'                        => 'Agentes',
  'index-agent'                         => 'Agente',
  'index-administrators'                => 'Administradores',  //new
  'index-administrator'                 => 'Adinistrador',  //new
  'index-users'                         => 'Usuarios',
  'index-user'                          => 'Usuario',
  'index-tickets'                       => 'Tiquets',
  'index-open'                          => 'Abierto',
  'index-closed'                        => 'Cerrado',
  'index-total'                         => 'Total',
  'index-month'                         => 'Mes',
  'index-performance-chart'             => '¿Cuántos días en promedio toma resolver un tiquet?',
  'index-categories-chart'              => 'Distribución de Tiquets por Categoría',
  'index-agents-chart'                  => 'Distribución de Tiquets por Agente',

// tickets-admin/agent/____
  'agent-index-title'             => 'Administración de Agentes',
  'btn-create-new-agent'          => 'Crear un nuevo agente',
  'agent-index-no-agents'         => 'No existen agentes, ',
  'agent-index-create-new'        => 'Añadir agentes',
  'agent-create-title'            => 'Añadir Agente',
  'agent-create-add-agents'       => 'Añadir Agentes',
  'agent-create-no-users'         => 'No existen cuentas de usuarios, crea cuentas de usuarios primero.',
  'agent-create-select-user'      => 'Selecciona las cuentas de usuario para añadirlas como agentes',

// tickets-admin/administrators/____
  'administrator-index-title'                   => 'Administración de Administradores',  //new
  'btn-create-new-administrator'                => 'Crear un nuevo administrador',  //new
  'administrator-index-no-administrators'       => 'No existen administradores, ',  //new
  'administrator-index-create-new'              => 'Añadir administradores',  //new
  'administrator-create-title'                  => 'Añadir Administrador',  //new
  'administrator-create-add-administrators'     => 'Añadir Administradores',  //new
  'administrator-create-no-users'               => 'No existen cuentas de usuario, crea cuentas de usuario primero.',  //new
  'administrator-create-select-user'            => 'Selecciona las cuentas de usuario para añadirlas como administradores',  //new

// tickets-admin/category/____
  'category-index-title'          => 'Administración de Categorías',
  'btn-create-new-category'       => 'Crear categoría nueva',
  'category-index-no-categories'  => 'No existen categorías, ',
  'category-index-create-new'     => 'crear nueva categoría',
  'category-index-js-delete'      => '¿Estás seguro que desea borrar la categoría?: ',
  'category-create-title'         => 'Crear Categoría Nueva',
  'category-create-name'          => 'Nombre',
  'category-create-color'         => 'Color',
  'category-edit-title'           => 'Editar Categoría: :name',

// tickets-admin/priority/____
  'priority-index-title'          => 'Administración de Prioridades',
  'btn-create-new-priority'       => 'Crear prioridad nueva',
  'priority-index-no-priorities'  => 'No existen prioridades, ',
  'priority-index-create-new'     => 'crear nueva prioridad',
  'priority-index-js-delete'      => '¿Estás seguro que desea borrar la prioridad?: ',
  'priority-create-title'         => 'Crear Prioridad Nueva',
  'priority-create-name'          => 'Nombre',
  'priority-create-color'         => 'Color',
  'priority-edit-title'           => 'Editar Prioridad: :name',

// tickets-admin/status/____
  'status-index-title'            => 'Administración de Estados',
  'btn-create-new-status'         => 'Crear estado nuevo',
  'status-index-no-statuses'      => 'No existen estados,',
  'status-index-create-new'       => 'crear estado nuevo',
  'status-index-js-delete'        => '¿Estás seguro de que desea borrar el estado?: ',
  'status-create-title'           => 'Crear Estado Nuevo',
  'status-create-name'            => 'Nombre',
  'status-create-color'           => 'Color',
  'status-edit-title'             => 'Editar Estado: :name',

// tickets-admin/configuration/____
  'config-index-title'            => 'Administración de Configuraciones',
  'config-index-subtitle'         => 'Configuraciones',
  'btn-create-new-config'         => 'Añadir configuración nueva',
  'config-index-no-settings'      => 'No existen configuraciones,',
  'config-index-initial'          => 'Inicial',
  'config-index-tickets'          => 'Tiquets',
  'config-index-notifications'    => 'Notificaciones',
  'config-index-permissions'      => 'Permisos',
  'config-index-editor'           => 'Editor', //Added: 2016.01.14
  'config-index-other'            => 'Otro',
  'config-create-title'           => 'Crear: Nueva Configuración Global',
  'config-create-subtitle'        => 'Crear Configuración',
  'config-edit-title'             => 'Editar: Configuración Global',
  'config-edit-subtitle'          => 'Editar Configuraciones',
  'config-edit-id'                => 'ID',
  'config-edit-slug'              => 'Código',
  'config-edit-default'           => 'Valor predeterminado',
  'config-edit-value'             => 'Mi valor',
  'config-edit-language'          => 'Idioma',
  'config-edit-unserialize'       => 'Obtener los valores del array, y cambiar los valores',
  'config-edit-serialize'         => 'Get the serialized string of the changed values (to be entered in the field)',
  'config-edit-should-serialize'  => 'Serializar', //Added: 2016-01-16
  'config-edit-eval-warning'      => 'Si está seleccionado, el servidor usará eval()!
  									  No usar esto si eval() está desactivado en el servidor o si no tiene los conocimientos al respecto!
  									  Código específico ejecutado:', //Added: 2016-01-16
  'config-edit-reenter-password'  => 'Re-ingrese su clave', //Added: 2016-01-16
  'config-edit-auth-failed'       => 'Las claves no son iguales', //Added: 2016-01-16
  'config-edit-eval-error'        => 'Valor inválido', //Added: 2016-01-16
  'config-edit-tools'             => 'Herramientas:',

];
