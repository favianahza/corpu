<?php 
require_once '../functions.php';
$IdTask = $_POST["id_task"];
$type = $_POST["type"];
$member = $_POST["member"];
$active = $_POST["active"];
$id_teknisi = $_POST["id_teknisi"];



$taskDetail = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM t_task WHERE id_task = $IdTask"));

// Filtering for Task Type wether is Individual or Team Type !
// exit(json_encode(["Success" => $_POST])); DEBUGGING

if( $type == "Individu" ){

	// Individual Type
	$query = "UPDATE t_task SET status = 'IN PROGRESS', technician_id = $id_teknisi, active_member = 1 WHERE id_task = $IdTask";
	$result = mysqli_query($connect, $query) or die(mysqli_error($connect));

	// Updating current_task in t_teknisi
	mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task + 1 WHERE id_teknisi = '$id_teknisi'");
	mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = '$id_teknisi'");
} else {
	// Team Type
	// Get current list of Technician ID
	$query = "SELECT technician_id, member, active_member FROM t_task WHERE id_task = $IdTask";
	$getList = mysqli_query($connect, $query) or die(mysqli_error($connect));
	$list = mysqli_fetch_assoc($getList);


	//exit(json_encode(["TEST" => $list])); 
	if( $list["technician_id"] == NULL ){
		// If NULL, script will insert current Technician ID to the column for the firstime
		
		$query = "UPDATE t_task SET technician_id = '$id_teknisi"."+'".", active_member = active_member + 1 WHERE id_task = $IdTask";
		mysqli_query($connect, $query) or die(mysqli_error($connect));


		// Updating current_task & total_task in t_teknisi
		mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task + 1 WHERE id_teknisi = '$id_teknisi'");
		mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = '$id_teknisi'");

		exit(json_encode(["Success" => "Berhasil !"]));

	} else {
		// Check Active Member

		if( $list['active_member'] == $list['member'] - 1  ){
			// If this is the last time to increment Active Member, then script will set task status to IN PROGRESS

			$query = "UPDATE t_task SET technician_id = CONCAT(technician_id, '$id_teknisi"."+"."'), active_member = active_member + 1, status = 'IN PROGRESS' WHERE id_task = $IdTask";
			mysqli_query($connect, $query) or die(mysqli_error($connect));

			// Updating current_task & total_task in t_teknisi
			mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task + 1 WHERE id_teknisi = '$id_teknisi'");
			mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = '$id_teknisi'");

			exit(json_encode(["Success" => "Berhasil !"]));

		} else {
			// Appending Technician ID and Increment Active Member in t_task and status still NOT COMPLETED

			$query = "UPDATE t_task SET technician_id = CONCAT(technician_id, '$id_teknisi"."+"."'), active_member = active_member + 1 WHERE id_task = $IdTask";
			mysqli_query($connect, $query) or die(mysqli_error($connect));

			// Updating current_task & total_task in t_teknisi
			mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task + 1 WHERE id_teknisi = '$id_teknisi'");
			mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = '$id_teknisi'");

			exit(json_encode(["Success" => "Berhasil !"]));

		}

	}

}


if(mysqli_affected_rows($connect) > 0){
	exit(json_encode(["Success" => "Berhasil !"]));
} else {
	exit(json_encode(["Failed" => "Gagal !"]));	
}


 ?>