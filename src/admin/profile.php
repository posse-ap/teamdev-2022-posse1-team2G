<?php 
// $pdo=new PDO('mysql:host=localhost;dbname=mydb;charset=utf8','root','root');
// $message='トレーニングマックス';

require('../dbconnect.php');
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
}


$sql='SELECT * FROM users WHERE dbPractice.id=:id';
$statement=$db->prepare($sql);
$statement->bindValue(':id',$id,PDO::PARAM_INT);
$statement->execute();
$human=$statement->fetch(PDO::FETCH_ASSOC);
// $statement=null;
// $pdo=null;
// require_once 'view/profile.tql.php';
print_r($human);
