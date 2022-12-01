<?php
session_start(); 
require("../admin/database/connect.php");

$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');