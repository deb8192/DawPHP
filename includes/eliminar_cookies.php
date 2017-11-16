<?php
    session_start();
	setcookie("recordar_usuario", "", (time()+60*60*24*30), '/');
	setcookie("recordar_password", "", (time()+60*60*24*30), '/');
    header("Location:logout.php");
?>