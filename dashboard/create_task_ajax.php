<?php 
require_once '../functions.php';

if(isset($_POST["submit"])){

	// exit(json_encode(["debug"=>var_dump(($_POST["member"]))])); // DEBUGGING

	// If client not uploading 
	(count($_FILES) == 0) ? exit(json_encode(["Alert"=>"Anda tidak mengupload gambar !"])) : True ;


	// Uploading one file
	if(count($_FILES) == 1) {
		$id_client = $_POST['id_client'];
		$id = $_SESSION["id_user"];
		$file_name = $_FILES["file0"]["name"];
		$tmp_name = $_FILES["file0"]["tmp_name"];
		$error = $_FILES["file0"]["error"];
		$file_size = $_FILES["file0"]["size"];
		$tgl = date('Y-m-d');
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

		// Get values from $_POST
		$taskName = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["taskName"]));
		$lokasi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["lokasi"]));
		$deskripsi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["deskripsi"]));
		$tipe = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["tipe"]));
		$member = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["member"]));

		( ($taskName && $lokasi && $deskripsi) == "" ) ? exit(json_encode(["Alert"=>"Isi form dengan lengkap !"])) : True ;

		// Insert data to t_task table
		$query = "INSERT INTO t_task VALUES('', '$taskName', '$lokasi', '$deskripsi', DEFAULT, '$id', DEFAULT, '$tipe', '$member',DEFAULT, '$tgl')";
		

		(mysqli_query($connect, $query)) ? $task_id = mysqli_insert_id($connect) : die(mysqli_error($connect));
		$rand = substr(md5(microtime()),rand(0,26),8);
		$unique = $rand.'_'.date("m-d").'_'.$task_id;
		$newfile = $unique.'.'.$ext;

		(move_uploaded_file($tmp_name, "taskImg/".$newfile)) ? NULL :  exit(json_encode(["Alert"=>"Gagal Membuat Task !"]));

		// Insert Task Image
		$result = mysqli_query($connect, "INSERT INTO `t_task_img` VALUES('', '$newfile', '$task_id')") or die(mysqli_error($connect)); 

		// Update Client Issued Task in t_client
		mysqli_query($connect, "UPDATE t_client SET issued_task = issued_task + 1 WHERE id_client = $id_client");

		exit(json_encode(["Success"=>"Berhasil membuat Task !"]));

	}


	// Uploading multiple files
	else {
		// ID and Array Initialization
		$id = $_SESSION["id_user"];
		$id_client = $_POST['id_client'];
		$file_name = []; $tmp_name = []; $error = []; $file_size = []; $newfile = [];
		$tgl = date('Y-m-d');
		// Used for make sure that Task only inserted to table one time
		$counter = 0;

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


			// Insert task to t_task
			// Get values from $_POST
			if($counter <= 0){
			$counter += 1;
			$taskName = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["taskName"]));
			$lokasi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["lokasi"]));
			$deskripsi = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["deskripsi"]));
			$tipe = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["tipe"]));
			$member = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["member"]));

			// Insert data to t_task table
			$query = "INSERT INTO t_task VALUES('', '$taskName', '$lokasi', '$deskripsi', DEFAULT, '$id', DEFAULT, '$tipe', '$member', DEFAULT, '$tgl')";
			(mysqli_query($connect, $query)) ? $task_id = mysqli_insert_id($connect) : die(mysqli_error($connect));
			} else {
				NULL;
			}
		
			$rand = substr(md5(microtime()),rand(0,26),8);
			$unique = $rand.'_'.date("m-d").'_'.$task_id;
			$newfile[$i] = $unique.'.'.$ext;			

			(move_uploaded_file($tmp_name[$i], "taskImg/".$newfile[$i])) ? NULL :  exit(json_encode(["Alert"=>"Gagal Membuat Task !"]));

			// Insert Task Image
			$result = mysqli_query($connect, "INSERT INTO `t_task_img` VALUES('', '$newfile[$i]', '$task_id')") or die(mysqli_error($connect)); 
		}
		mysqli_query($connect, "UPDATE t_client SET issued_task = issued_task + 1 WHERE id_client = $id_client");
		exit(json_encode(["Success"=>"Berhasil membuat Task !"]));

	}

}


 ?>