<?php 
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'corpu');
date_default_timezone_set('Asia/Jakarta');

// REGISTER USER
function register(){
	global $connect;
	$fullname = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["fullname"]));
	$username = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["username"]));
	$password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["pass"]));
	$confirmation = htmlspecialchars(mysqli_real_escape_string($connect, $_POST["cpass"]));
	
	// Password Confirmation
	if( $password != $confirmation ){
		echo "<script>alert('Konfirmasi password yang dimasukan salah !');</script>";
		return false;
	}

	// Check Username
	$check = mysqli_query($connect, "SELECT username FROM t_user WHERE username = '$username'");
	if( mysqli_num_rows($check) === 1 ){
		echo "<script>alert('Username yang dimasukan sudah digunakan !')</script>";
		return false;
	}

	// Hash Password
	$hashed = password_hash($password, PASSWORD_DEFAULT);

	// 1 = CLIENT, 2 = TEKNISI
	($_POST["utype"] == 1) ? $type = 1 : $type = 2;

	$query = "INSERT INTO t_user VALUES ('', '$fullname', '$username', '$hashed', DEFAULT, $type)";
	(mysqli_query($connect, $query)) ? $last_id = mysqli_insert_id($connect) : exit;
 
	($type == 1) ? $n_query = "INSERT INTO t_client VALUES('', '$fullname', DEFAULT, DEFAULT, $last_id)" : 
	$n_query = "INSERT INTO t_teknisi VALUES('', '$fullname', DEFAULT, DEFAULT, DEFAULT, $last_id)";
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

	 // Get User Information
	 $_SESSION["id_user"] = $rows["id"];
	 $_SESSION["type"] = $rows["type"];	 
	 $record = gdata_user($_SESSION["id_user"], $_SESSION["type"]);

	 $_SESSION["fullname"] = $record['fullname'];
	 $_SESSION["username"] = $record['username'];
	 $_SESSION["profile_pict"] = $record['profile_pict'];
	 $_SESSION["acc_type"] = $record['type'];

	 // Client Specific Information
	 if( $_SESSION["type"] == 1 ){
	 $_SESSION["issued_task"] = $record["issued_task"];
	 $_SESSION["completed_issued_task"] = $record["completed_issued_task"];
	 $_SESSION['id_client'] = $record['id_client'];
	 }

	 // Technician Specific Information
	 if( $_SESSION["type"] == 2 ){
	 $_SESSION["current_task"] = $record['current_task'];
	 $_SESSION["completed_task"] = $record['completed_task'];
	 $_SESSION["total_task"] = $record['total_task'];
	 $_SESSION["id_teknisi"] = $record['id_teknisi'];
	 }

	 $_SESSION["logged_in"] = true;
	 $_SESSION["activity"] = time();

	 if( isset($_POST["cookie"]) ){
	 	setcookie('login[stat]', true, time()+2*24*60*60);
	 	setcookie('login[id_user]', base64_encode(base64_encode(strval($_SESSION["id_user"]))), time()+2*24*60*60);
	 	setcookie('login[type]', base64_encode(base64_encode(strval($_SESSION["type"]))), time()+2*24*60*60);
	 }
	 return true;
	
}





// SESSION EXPIRATION
function session_exp(){
	if (isset($_SESSION['activity']) && (time() - $_SESSION['activity'] > 36000)) {
	    // last request was more than 10 hour ago
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

	// Get Client Data
	if( $type == 1 ) {
	$query = "SELECT (SELECT id_client FROM t_client WHERE t_client.t_user_id = t_user.id) AS id_client, fullname, username, profile_pict,  (SELECT description FROM t_utype WHERE t_user.type = t_utype.type) AS type, (SELECT issued_task FROM t_client WHERE t_client.t_user_id = t_user.id) AS issued_task, (SELECT completed_issued_task FROM t_client WHERE t_client.t_user_id = t_user.id) AS completed_issued_task  FROM t_user WHERE id = $ID;";
	$result = mysqli_query($connect, $query);
	}

	// Get Technician Data
	if( $type == 2 ) {
	$query = "SELECT (SELECT id_teknisi FROM t_teknisi WHERE t_user_id = t_user.id) AS id_teknisi, fullname, username, profile_pict, (SELECT description FROM t_utype WHERE t_user.type = t_utype.type) AS type, (SELECT current_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS current_task, (SELECT completed_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS completed_task, (SELECT total_task FROM t_teknisi WHERE t_user.fullname = t_teknisi.fullname) AS total_task FROM t_user WHERE id = $ID";

	$result = mysqli_query($connect, $query);
	}

	return mysqli_fetch_assoc($result);
}





// GET TASK CREATED BY SPECIFIC USER
function gtask_user($ID){
	global $connect;
	$records = [];
	$query = " SELECT *, (SELECT COUNT(img_name) FROM t_task_img WHERE t_task_img.id_task = t_task.id_task) AS total_img, ROUND(CHAR_LENGTH(technician_id)/2) AS jml_teknisi FROM t_task WHERE issuer_id = $ID";
	$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
	while( $record = mysqli_fetch_assoc($result) ){
		$records[] = $record;
	}
	return $records;
}





// GET TASK DETAIL
function gtask_detail($ID_TASK=1, $total_img=1, $total_teknisi=1, $teknisi_yang_dibutuhkan=1){
	global $connect;

	if( $total_teknisi == 1 && $teknisi_yang_dibutuhkan == 1 && $total_img == 1){ // Individual Task with Single Image
		// var_dump('DEBUG'); exit();
		$query =  "SELECT *, (SELECT img_name FROM t_task_img WHERE id_task = $ID_TASK) AS foto0, (SELECT fullname FROM t_teknisi WHERE id_teknisi = technician_id) AS nama_teknisi, (SELECT t_teknisi.t_user_id FROM t_teknisi WHERE id_teknisi = technician_id) AS id_user_teknisi,(SELECT profile_pict FROM t_user WHERE id = id_user_teknisi) AS img_teknisi FROM t_task WHERE id_task = $ID_TASK";

		$result = mysqli_query($connect, $query);
		return mysqli_fetch_assoc($result);
	}

	else if($total_teknisi == 1 && $teknisi_yang_dibutuhkan == 1 && $total_img > 1 ) {// Individual Task with Multiple Image
		// Get all Images related to the task
		$result = mysqli_query($connect, "SELECT img_name FROM t_task_img WHERE id_task = $ID_TASK") or die(mysqli_query($connect));

		// Fetch Images data
		$images = [];
		while($image = mysqli_fetch_assoc($result)){
			$images[] = $image;
		}

		// Get all detail about Task
		$query = "SELECT *, (SELECT fullname FROM t_teknisi WHERE id_teknisi = technician_id) AS nama_teknisi, (SELECT t_teknisi.t_user_id FROM t_teknisi WHERE id_teknisi = technician_id) AS id_user_teknisi,(SELECT profile_pict FROM t_user WHERE id = id_user_teknisi) AS img_teknisi FROM t_task WHERE id_task = $ID_TASK";

		$task = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($task);


		// Appending Images Data to the result A.K.A. Insert $images to the $result as index foto[i]
		for($i = 0; $i < $total_img; $i++){
			$result["foto"][$i] = $images[$i]["img_name"];
		}

		return $result;
	} 

	else { // Team Task with Single or Multiple Image

		// Get all detail about Task
		$getTask = mysqli_query($connect, "SELECT * FROM t_task WHERE id_task = $ID_TASK") or die(mysqli_error($connect));

		$result = mysqli_fetch_assoc($getTask);
		
		// Get all image that are related to Task
		$getImg = mysqli_query($connect, "SELECT img_name FROM t_task_img WHERE id_task = $ID_TASK") or die(mysqli_error($connect));

		$images = [];
		while( $record = mysqli_fetch_assoc($getImg) ){
			$images[] = $record;
		}

		// Count Images
		if( count($images) == 1 ){
			// For single Images
			$result["foto0"] = $images[0]["img_name"];
		} else {
			// For multiple Images
			// Insert Images to Result Variables
			$foto = [];
			for( $i = 0; $i < $total_img; $i++ ){
				$result["foto"][$i] = $images[$i]["img_name"];
			}			
		}



		// Get Teknisi that related to the Task
		$list_id_teknisi = explode("+", $result["technician_id"]);


		$workers = [];
		for($i = 0; $i < $total_teknisi; $i++){
		$getWorkers = mysqli_query($connect, "SELECT fullname AS nama_teknisi_".$i." , id_teknisi AS id_teknisi".$i.",t_user_id, (SELECT profile_pict FROM t_user WHERE id = t_user_id) AS profile_pict".$i." FROM t_teknisi WHERE id_teknisi=$list_id_teknisi[$i]");
		$workers[] = mysqli_fetch_assoc($getWorkers);
		}

		// Insert Workers to Result Variables
		for( $i = 0; $i < $total_teknisi; $i++ ){
			$result["nama_teknisi"][$i] = $workers[$i]["nama_teknisi_".$i];
			$result["img_teknisi"][$i] = $workers[$i]["profile_pict".$i];
			$result["id_teknisi"][$i] = $workers[$i]["id_teknisi".$i];
		}
		
		return $result;
	}

}





// GET ALL AVAILABLE TASK
function gAll_AvailableTask($ID){
	global $connect;
	$records = [];
	$query = "SELECT *, (SELECT fullname FROM t_user WHERE issuer_id = id) AS pengaju, (SELECT COUNT(img_name) FROM t_task_img WHERE t_task_img.id_task = t_task.id_task) AS total_img, ROUND(CHAR_LENGTH(technician_id)/2) AS jml_teknisi, member - active_member AS technician_needed FROM t_task WHERE status = 'NOT COMPLETED' AND member != active_member AND technician_id NOT LIKE '%$ID%' OR technician_id IS NULL;";
	$result = mysqli_query($connect, $query) or die(mysqli_error($connect));

	while( $record = mysqli_fetch_assoc($result) ){
		$records[] = $record;
	}

	return $records;
}

 ?>