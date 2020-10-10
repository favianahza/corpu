<?php 
session_start();
session_destroy();
unset($_SESSION);
setcookie('login[stat]', '', time()-1);
setcookie('login[id_user]', '', time()-1);
setcookie('login[type]', '', time()-1);
header("location:index");
 ?>
