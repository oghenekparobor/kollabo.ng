<?php
session_start();
require("database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');