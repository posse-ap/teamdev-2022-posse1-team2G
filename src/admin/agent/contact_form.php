<?php
require('../../dbconnect.php');
session_start();
// sessionに保存されたcompany_id
$id = $_SESSION['id'];

include('../_parts/_header.php');
?>
