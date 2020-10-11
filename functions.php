<?php 
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'corpu');


// REGISTER USER
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

	// 1 = CLIENT, 2 = TEKNISI
	($_POST["utype"] == 1) ? $type = 1 : $type = 2;
	
	$query = "INSERT INTO t_user VALUES ('', '$fullname', '$username', '$hashed', DEFAULT, $type)";
	(mysqli_query($connect, $query)) ? $last_id = mysqli_insert_id($connect) : exit;

	($type == 1) ? $n_query = "" : $n_query = "INSERT INTO t_teknisi VALUES('$last_id', '$fullname', DEFAULT, DEFAULT, DEFAULT)";
	var_dump(mysqli_query($connect, $n_query) or die(mysqli_error($connect)));

	return mysqli_affected_rows($connect);
}


// LOGIN USER
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
	 $_SESSION["activity"] = time();

	 // Get User Information
	 $record = gdata_user($_SESSION["id_user"], $_SESSION["type"]);
	 $_SESSION["fullname"] = $record['fullname'];
	 $_SESSION["username"] = $record['username'];
	 $_SESSION["profile_pict"] = $record['profile_pict'];
	 $_SESSION["acc_type"] = $record['type'];
	 $_SESSION["current_task"] = $record['current_task'];
	 $_SESSION["completed_task"] = $record['completed_task'];
	 $_SESSION["total_task"] = $record['total_task'];

	 if( isset($_POST["cookie"]) ){
	 	setcookie('login[stat]', true, time()+2*24*60*60);
	 	setcookie('login[id_user]', base64_encode(base64_encode(strval($_SESSION["id_user"]))), time()+2*24*60*60);
	 	setcookie('login[type]', base64_encode(base64_encode(strval($_SESSION["type"]))), time()+2*24*60*60);
	 }

	 return true;
	
}


// SESSION EXPIRATION
function session_exp(){
	if (isset($_SESSION['activity']) && (time() - $_SESSION['activity'] > 1800)) {
	    // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	    header("location:../index");
	} else {
		$_SESSION['activity'] = time(); // update last activity time stamp
	}
}



// GET DATA USER
function gdata_user($ID, $type){
	global $connect;
	if( $type == 2 ) {
	$query = "SELECT fullname, username, profile_pict, (SELECT description FROM t_utype WHERE t_user.type = t_utype.type) AS type, (SELECT current_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS current_task, (SELECT completed_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS completed_task, (SELECT total_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS total_task FROM t_user WHERE id = $ID";

	$rest = mysqli_query($connect, $query);		
	}
	return mysqli_fetch_assoc($rest);
}


 ?>