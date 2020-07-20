<?php 
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'corpu');

function register(){
	global $connect;
	$fullname = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["fullname"]));
	$username = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["username"]));
	$password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["pass"]));
	$confirmation = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["cpass"]));
	

	if( $password != $confirmation ){
		echo "<script>alert('Konfirmasi password yang dimasukan salah !');</script>";
		return false;
	}

	$check = mysqli_query($connect, "SELECT username FROM t_user WHERE username = '$username'");
	if( mysqli_num_rows($check) === 1 ){
		echo "<script>alert('Username yang dimasukan sudah digunakan !')</script>";
		return false;
	}

	$hashed = password_hash($password, PASSWORD_DEFAULT);


	$query = "INSERT INTO t_user VALUES ('', '$fullname', '$username', '$hashed', DEFAULT, DEFAULT)";

	mysqli_query($connect, $query);

	return mysqli_affected_rows($connect);
}

function login(){
	global $connect;
	
	$username = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["username"]));
	$password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["password"]));

	$check = mysqli_query($connect, "SELECT * FROM t_user WHERE username = '$username'");
	if( mysqli_num_rows($check) === 0 ){
		echo "<script>alert('Username yang dimasukan tidak terdaftar !');</script>";
		return false;
	}

	 $rows = mysqli_fetch_assoc($check);

	 if( !password_verify($password, $rows["password"]) ){
	 	echo "<script>alert('Password yang dimasukan salah !');</script>";
		return false;
	 }

	 $_SESSION["logged_in"] = true;
	 $_SESSION["id_user"] = $rows["id"];
	 $_SESSION["type"] = $rows["type"];

	 if( isset($_POST["cookie"]) ){
	 	setcookie('login[stat]', true, time()+2*24*60*60);
	 	setcookie('login[id_user]', base64_encode(base64_encode(strval($_SESSION["id_user"]))), time()+2*24*60*60);
	 }

	 return true;
	
}

function gdata_user($ID){
	global $connect;
	$query = "SELECT fullname, username, profile_pict, type FROM t_user WHERE id = $ID";
	$rest = mysqli_query($connect, $query);

	return mysqli_fetch_assoc($rest);
}


 ?>