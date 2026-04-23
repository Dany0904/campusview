<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage(
        'local_campusview',
        'Campus View'
    );

    $settings->add(new admin_setting_configcheckbox(
        'local_campusview/enableredirect',
        'Activar campus como vista de cursos',
        'Si está activo, reemplaza la página de "Mis cursos" con el campus visual.',
        0
    ));

    $ADMIN->add('localplugins', $settings);
}