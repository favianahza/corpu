<?php 
require_once '../functions.php';
// Changing Password
if( isset($_POST["old_pass"]) && isset($_POST["conf_pass"]) && isset($_POST["new_pass"]) ){

	$new_pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["new_pass"]));
	$conf_pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["conf_pass"]));
	$old_pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["old_pass"]));

	// Password Verify
	$id = $_SESSION["id_user"];
	$check = mysqli_query($connect, "SELECT password FROM t_user WHERE id = $id");

	$pass = mysqli_fetch_assoc($check)["password"];

	($new_pass != $conf_pass) ? exit(json_encode(["FailPass"=>"Konfirmasi Password yang dimasukan tidak sama !"])) : NULL ;

	(!password_verify($old_pass, $pass)) ? exit(json_encode(["FailPass"=>"Password lama yang dimasukan salah !"])) : NULL ;

	$updated_pass = password_hash($new_pass, PASSWORD_DEFAULT);

	// Update the Password
	$result = mysqli_query($connect, "UPDATE t_user SET password = '$updated_pass' WHERE id = $id") or die(mysqli_error($connect)); 
	if( $result ){
		mysqli_close($connect);
		exit(json_encode(["Success" => "Password berhasil diubah !"]));
	} else {
		mysqli_close($connect);
		exit(json_encode(["Failed" => "Password gagal diubah !"]));
	}

} 

// Changing Profile Pict
if( isset($_POST["pass"]) ){
	// Password Verify
	$id = $_SESSION["id_user"];
	$check = mysqli_query($connect, "SELECT password FROM t_user WHERE id = $id");
	$password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["pass"]));
	$verify = mysqli_fetch_assoc($check)["password"];
	(!password_verify($password, $verify)) ? exit(json_encode(["FailPass"=>"Password yang dimasukan salah !"])) : NULL ;


	// Upload Validation
	(!isset($_FILES["file"])) ? exit(json_encode(["Alert"=>"Anda tidak mengupload gambar !"])) : NULL;
	$id = $_SESSION["id_user"];
	$unique = $id.'_'.date("H-i-s");
	$file_name = $_FILES["file"]["name"];
	$tmp_name = $_FILES["file"]["tmp_name"];
	$error = $_FILES["file"]["error"];
	$file_size = $_FILES["file"]["size"];

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

	$newfile = $unique.'.'.$ext;

	(move_uploaded_file($tmp_name, "../assets/img/profile/".$newfile)) ? $_SESSION["profile_pict"] = $newfile :  exit(json_encode(["Alert"=>"Gagal Upload !"]));

	// Updating Profile Pict in Database
	$result = mysqli_query($connect, "UPDATE t_user SET profile_pict = '$newfile' WHERE id = $id") or die(mysqli_error($connect)); 

	exit(json_encode(["Success"=>"Foto berhasil diubah !","ImageName"=>$newfile]));
}

 ?>