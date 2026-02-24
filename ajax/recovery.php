<?php
	session_start();
	include("../settings/connect_datebase.php");
	
	$login = $_POST['login'];
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."';");
	
	$id = -1;
	if($user_read = $query_user->fetch_row()) {
		$id = $user_read[0];
	}
	
	function PasswordGeneration() {
		$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$max=10;
		$size=StrLen($chars)-1;
		$password="";
		while($max--) {
			$password.=$chars[rand(0,$size)];
		}
		return $password;
	}
	
	if($id != -1) {
		$password = PasswordGeneration();

		$query_password = $mysqli->query("SELECT * FROM `users` WHERE `password`= '".$password."';");
		while($password_read = $query_password->fetch_row()) {
			$password = PasswordGeneration();
		}

		$mysqli->query("UPDATE `users` SET `password`='".$password."' WHERE `login` = '".$login."'");

		echo("Ваш пароль был только что изменён. Новый пароль: ".$password);
	}
?>