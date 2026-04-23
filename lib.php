<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Hook para redirigir páginas
 */
function local_campusview_before_http_headers() {
    global $PAGE;

    // Verificar setting
    $enabled = get_config('local_campusview', 'enableredirect');

    if (empty($enabled)) {
        return;
    }

    // Solo aplicar en /my/courses.php
    if ($PAGE->url->compare(new moodle_url('/my/courses.php'), URL_MATCH_BASE)) {

        // Evitar loop
        if ($PAGE->url->get_path() !== '/local/campusview/index.php') {
            redirect(new moodle_url('/local/campusview/index.php'));
        }
    }
}