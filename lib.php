<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Hook para redirigir páginas
 */
function local_campusview_before_http_headers() {
    global $PAGE;

    // Solo aplicar si estamos en la página de cursos
    if ($PAGE->url->compare(new moodle_url('/my/courses.php'), URL_MATCH_BASE)) {

        // Evitar loop infinito
        if ($PAGE->url->get_path() !== '/local/campusview/index.php') {
            redirect(new moodle_url('/local/campusview/index.php'));
        }
    }
}