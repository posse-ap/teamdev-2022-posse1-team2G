<?php
require('../dbconnect.php');

$sql = "SELECT handling_job_category from company_overview";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $value){
  print_r($value['handling_job_category']);
}

?>

<pre>
  
  <?php  print_r($result); ?>
</pre>