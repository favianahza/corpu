<?php 
require_once '../functions.php';

if(isset($_POST["submit"])){
	// exit(json_encode(["Alert"=>$_POST])); // DEBUGGING

	// Response with single image
	// If client not uploading 
	(count($_FILES) == 0) ? exit(json_encode(["Alert"=>"Anda tidak mengupload gambar !"])) : True ;


	// Uploading one file
	if(count($_FILES) == 1) {
		$file_name = $_FILES["file0"]["name"];
		$tmp_name = $_FILES["file0"]["tmp_name"];
		$error = $_FILES["file0"]["error"];
		$file_size = $_FILES["file0"]["size"];

		// Check if user uploading an Image
		if( $error == 4 ){
			exit(json_encode(["Alert"=>"Anda tidak mengupload gambar !"]));
		}

		// Check file size (1.000.000 Bytes == 1 MB)
		if( $file_size > 1000000 ){
			exit(json_encode(["Alert"=>"Ukuran file yang diupload terlalu besar !"]));
		}

		// Check uploaded file extension
		$valid_ext = ["jpg", "png", "gif", "jpeg"];
		$ext = explode(".", $file_name);
		$ext = strtolower(end($ext));
		if( !in_array($ext, $valid_ext) ){
			exit(json_encode(["Alert"=>"Yang anda upload bukan gambar !"]));
		}

		// Get values from $_POST & other
		$taskName = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["taskName"]));
		$deskripsi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["deskripsi"]));
		$id_task = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["id_task"]));
		$issuer_id = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["issuer_id"]));
		$id_teknisi = $_SESSION["id_teknisi"];

		// exit(json_encode(["Alert"=>$issuer_id]));


		( $deskripsi == "" ) ? exit(json_encode(["Alert"=>"Isi form dengan lengkap !"])) : True ;

		// Insert data to t_response
		$query = "INSERT INTO t_response VALUES('', '$taskName', '$deskripsi', '$id_task')";



		(mysqli_query($connect, $query)) ? $response_id = mysqli_insert_id($connect) : die(mysqli_error($connect));
		$rand = substr(md5(microtime()),rand(0,26),8);
		$unique = $rand.'_'.date("m-d").'_'.$response_id;
		$newfile = $unique.'.'.$ext;

		// exit(json_encode(["Alert"=>$newfile])); // DEBUGGING
		(move_uploaded_file($tmp_name, "taskResponse/".$newfile)) ? NULL :  exit(json_encode(["Alert"=>"Gagal Membuat Laporan !"]));

		// Insert Task Image
		$result = mysqli_query($connect, "INSERT INTO `t_response_img` VALUES('', '$newfile', '$response_id')") or die(mysqli_error($connect)); 

		// Update Technician Current & Completed Task in t_teknisi
		mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task - 1, completed_task = completed_task + 1 WHERE id_teknisi = $id_teknisi");
		mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = $id_teknisi");

		// Update Client current Issued Task and Completed Issued Task
		mysqli_query($connect, "UPDATE t_client SET issued_task = issued_task - 1, completed_issued_task = completed_issued_task + 1 WHERE t_user_id = $issuer_id");

		// Finally update t_task status to COMPLETED
		mysqli_query($connect, "UPDATE t_task SET status = 'COMPLETED' WHERE id_task = $id_task");

		exit(json_encode(["Success"=>"Berhasil membuat laporan !"]));

	}


	// Uploading multiple files
	else {
		// ID and Array Initialization
		$id_teknisi = $_SESSION["id_teknisi"];
		$file_name = []; $tmp_name = []; $error = []; $file_size = []; $newfile = [];

		// Used for make sure that Task only inserted to table one time
		$counter = 0;
	// exit(json_encode(["Success"=>$_FILES]));
		for($i = 0; $i < count($_FILES); $i++) {		
			// Get Files Attribute	
			$file_name[$i] = $_FILES["file".$i]["name"];
			$tmp_name[$i] = $_FILES["file".$i]["tmp_name"];
			$error[$i] = $_FILES["file".$i]["error"];
			$file_size[$i] = $_FILES["file".$i]["size"];

			// Check if user uploading an Image
			if( $error[$i] == 4 ){
				exit(json_encode(["Alert"=>"Anda tidak mengupload gambar !"]));
			}

			// Check file size (1.000.000 Bytes == 1 MB)
			if( $file_size[$i] > 1000000 ){
				exit(json_encode(["Alert"=>"Ukuran file yang diupload terlalu besar !"]));
			}

			// Check uploaded file extension
			$valid_ext = ["jpg", "png", "gif", "jpeg"];
			$ext = explode(".", $file_name[$i]);
			$ext = strtolower(end($ext));
			if( !in_array($ext, $valid_ext) ){
				exit(json_encode(["Alert"=>"Yang anda upload bukan gambar !"]));
			}


			// Insert response to t_response
			// Get values from $_POST
			if($counter <= 0){
			$counter += 1;
			$taskName = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["taskName"]));
			$deskripsi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["deskripsi"]));
			$id_task = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["id_task"]));
			$issuer_id = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["issuer_id"]));


			// Insert data to t_response table
			$query = "INSERT INTO t_response VALUES('', '$taskName', '$deskripsi', '$id_task')";


			(mysqli_query($connect, $query)) ? $response_id = mysqli_insert_id($connect) : die(mysqli_error($connect));
			} else {
				NULL;
			}
		
			$rand = substr(md5(microtime()),rand(0,26),8);
			$unique = $rand.'_'.date("m-d").'_'.$response_id;
			$newfile[$i] = $unique.'.'.$ext;			

			(move_uploaded_file($tmp_name[$i], "taskResponse/".$newfile[$i])) ? NULL :  exit(json_encode(["Alert"=>"Gagal Membuat Laporan !"]));

			// Insert Response Image
			mysqli_query($connect, "INSERT INTO `t_response_img` VALUES('', '$newfile[$i]', $response_id)") or die(mysqli_error($connect));

		}
		// Update Technician Current & Completed Task in t_teknisi
		mysqli_query($connect, "UPDATE t_teknisi SET current_task = current_task - 1, completed_task = completed_task + 1 WHERE id_teknisi = $id_teknisi");
		mysqli_query($connect, "UPDATE t_teknisi SET total_task = current_task + completed_task WHERE id_teknisi = $id_teknisi");

		// Update Client current Issued Task and Completed Issued Task
		mysqli_query($connect, "UPDATE t_client SET issued_task = issued_task - 1, completed_issued_task = completed_issued_task + 1 WHERE t_user_id = $issuer_id");

		// Finally update t_task status to COMPLETED
		mysqli_query($connect, "UPDATE t_task SET status = 'COMPLETED' WHERE id_task = $id_task");

		exit(json_encode(["Success"=>"Berhasil membuat Task !"]));

	}

}


 ?>