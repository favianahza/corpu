<?php 
require_once '../functions.php';
$IdTask = $_POST["id_task"];
$type = $_POST["type"];
$member = $_POST["member"];
$active = $_POST["active"];
$id_teknisi = $_POST["id_teknisi"];

// exit(json_encode(["Success" => $_POST])); //DEBUGGING
// Remove Technician ID from the Task

if( $_POST["type"] == "Individu" ){
	// If the task is Individual Type
	$query = "UPDATE t_task SET technician_id = REPLACE(technician_id, '$id_teknisi', NULL), active_member = active_member - 1, status = 'NOT COMPLETED' WHERE id_task = $IdTask;";

} else {
	// If the task is Team Type
	if( $active == 1 ){
		// If this is the last member that currently in the task, SET technician_id to NULL
		$query = "UPDATE t_task SET technician_id = REPLACE(technician_id, '$id_teknisi"."+"."', NULL), active_member = 0, status = 'NOT COMPLETED' WHERE id_task = $IdTask;";

	} else {
		// If this is not the last member of the task,  Don't SET technician_id to NULL
		$query = "UPDATE t_task SET technician_id = REPLACE(technician_id, '$id_teknisi"."+"."', ''), active_member = active_member - 1, status = 'NOT COMPLETED' WHERE id_task = $IdTask;";

	}	
}


mysqli_query($connect, $query) or die(mysqli_error($connect));

// Decrement Current Task & Total Task of the Technician
mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task - 1, total_task = total_task - 1 WHERE id_teknisi = $id_teknisi");

if(mysqli_affected_rows($connect) > 0){
	exit(json_encode(["Success" => "Berhasil !"]));
} else {
	exit(json_encode(["Failed" => "Gagal !"]));	
}


 ?>