<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<?php


if(isset($_POST['key']))
{
	//var $res=array();
	$u_id=$_SESSION['user_id'];
	//$json = json_decode(file_get_contents($_POST['key']), true);
	$sql="UPDATE student SET subject_choice='{$_POST["key"]}' WHERE u_id='{$u_id}'";
	
	mysql_query($sql,$connection);
}
?>