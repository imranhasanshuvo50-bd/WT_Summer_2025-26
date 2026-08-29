<?php

session_start();

if (!empty($_SESSION['queue'])) {

    $nextPatient = array_shift($_SESSION['queue']);

    $nextPatient[4] = "In Consultation";

    $_SESSION['current_patient'] = $nextPatient;
}

header("Location: reciption_queue.php");

exit;

?>