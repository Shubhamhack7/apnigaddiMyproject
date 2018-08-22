<?php
session_start();
if(empty($_SESSION['id']) && empty($_SESSION['user']))
{
			header('Location: ../index.html');
			die();
}
else
{
	session_destroy();
	header('Location: ../index.html');
	die();
}
?>