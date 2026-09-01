<?php

include "config.php";


$result = mysqli_query($conn,"SELECT queue.queue_id,queue.token_number,patients.name AS patient_name,users.name AS doctor_name FROM queue LEFT JOIN patients
                            ON queue.patient_id = patients.patient_id LEFT JOIN doctors ON queue.doctor_id = doctors.doctor_id LEFT JOIN users ON doctors.user_id = users.id
                            WHERE queue.status='Waiting' ORDER BY queue.queue_id ASC LIMIT 1");

$patient = mysqli_fetch_assoc($result);

if($patient){

    $queue_id = $patient['queue_id'];
    mysqli_query($conn,"UPDATE queue SET status='In Consultation'WHERE queue_id='$queue_id'");
}

header("Location: reciption_queue.php");
exit();
?>