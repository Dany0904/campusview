<?php
require('../../config.php');
require_once($CFG->libdir . '/completionlib.php');
require_login();

$PAGE->set_url('/local/campusview/index.php');
$PAGE->set_pagelayout('fullwidth');
$PAGE->set_title('Campus');
$PAGE->set_heading('Campus');

$courses = enrol_get_my_courses();

$data = [];

foreach ($courses as $course) {

    $completion = new completion_info($course);

    $progress = 0;

    if ($completion->is_enabled()) {

        $modinfo = get_fast_modinfo($course);
        $cms = $modinfo->get_cms();

        $total = 0;
        $completed = 0;

        foreach ($cms as $cm) {

            if (!$cm->uservisible) continue;

            $completiondata = $completion->get_data($cm, true);

            if ($completiondata->completionstate != COMPLETION_INCOMPLETE) {
                $completed++;
            }

            $total++;
        }

        if ($total > 0) {
            $progress = round(($completed / $total) * 100);
        }
    }

    $data[] = [
        'id' => $course->id,
        'fullname' => format_string($course->fullname),
        'shortname' => format_string($course->shortname),
        'progress' => $progress
    ];
}

$PAGE->requires->js_call_amd('local_campusview/campus', 'init', [
    (object)[ 'courses' => array_values($data) ]
]);

$PAGE->requires->css('/local/campusview/styles.css');

echo $OUTPUT->header();
?>

<div id="campus-container">
    <svg id="campus-svg" viewBox="0 0 1000 600" preserveAspectRatio="xMidYMid meet">

        <defs>
            <radialGradient id="fadeMask" cx="50%" cy="50%" r="70%">
                <stop offset="60%" stop-color="white" stop-opacity="1"/>
                <stop offset="100%" stop-color="white" stop-opacity="0"/>
            </radialGradient>

            <mask id="maskFade">
                <rect width="100%" height="100%" fill="url(#fadeMask)" />
            </mask>

            <!--  overlay suave -->
            <linearGradient id="topLight" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="white" stop-opacity="0.25"/>
                <stop offset="60%" stop-color="white" stop-opacity="0"/>
            </linearGradient>

            <!--  sombra inferior -->
           <!--  <linearGradient id="bottomShade" x1="0" y1="0" x2="0" y2="1">
                <stop offset="40%" stop-color="black" stop-opacity="0"/>
                <stop offset="100%" stop-color="black" stop-opacity="0.25"/>
            </linearGradient> -->

        </defs>

        <!-- fondo -->
        <image 
            href="pix/background.svg" 
            x="0" y="0" 
            width="1000" height="600"
            mask="url(#maskFade)"
        />

        <!--  luz superior -->
        <rect width="100%" height="100%" fill="url(#topLight)" />

        <!--  sombra inferior -->
        <rect width="100%" height="100%" fill="url(#bottomShade)" />

    </svg>
</div>

<?php
echo $OUTPUT->footer();