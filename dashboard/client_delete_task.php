<?php 
require_once '../functions.php';

if( $_POST["active_member"] > 0 ){
	exit(json_encode(["Failed" => "Tidak bisa dihapus !"]));
}

$IdTask = $_POST["id_task"];
$IdClient = $_SESSION["id_client"];

// Check Task Condition !
$active = mysqli_fetch_assoc(mysqli_query($connect, "SELECT active_member FROM t_task WHERE id_task  = '$IdTask'"))["active_member"];
($active > 0) ? exit(json_encode(["Failed" => "Sudah ada teknisi yang akan mengerjakan Task ini"])) : NULL ;


// Deleting Task Information in t_task
$query = "DELETE FROM t_task WHERE id_task = $IdTask";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));

// Decrement issued_task in t_client
mysqli_query($connect, "UPDATE t_client SET issued_task = issued_task - 1 WHERE id_client = $IdClient");

if(mysqli_affected_rows($connect) > 0){
	exit(json_encode(["Success" => "Task berhasil dihapus !"]));	
} else {
	exit(json_encode(["Failed" => "Task gagal dihapus !"]));	
}


 ?>