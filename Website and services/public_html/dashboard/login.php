<?php
include 'connection.php';
session_start();
if(isset($_POST['login']))
{
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$sql = "SELECT * FROM admin_data";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$username = $row['USERNAME'];
		$password = $row['PASSWORD'];
		$valid = password_verify($pass,$password);
		if($user == $username && $valid)
		{
			$_SESSION['id'] = $row['ID'];
			$_SESSION['user'] = $row['USERNAME'];
			header('Location: dashboard.php');
			die();
		}
		else
		{
			session_destroy();
			header('Location: ../index.html');
			die();
		}
	}
	else
	{
		session_destroy();
		header('Location: ../index.html');
		die();
	}
}
else
{
	session_destroy();
	header('Location: ../index.html');
	die();
}
?>