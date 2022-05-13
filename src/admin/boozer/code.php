<?php
require('../../dbconnect.php');
// $conn = mysqli_connect("localhost","root","","phpcrud");

// trueだったら
if(isset($_POST['checking_add']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $class = $_POST['class'];
    $section = $_POST['section'];

    $query = "INSERT INTO students (fname,lname,class,section) VALUES ('$fname','$lname','$class','$section')";
  // $query_run = mysqli_query($conn, $query);
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

    if(isset($result))
    {
        echo $return  = "データを挿入しました";
    }
    else
    {
        echo $return  = "Something Went Wrong.!";
    }
}

// $conn = mysqli_connect("localhost","root","","phpcrud");

// if(isset($_POST['checking_add']))
// {
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $class = $_POST['class'];
//     $section = $_POST['section'];

//     $query = "INSERT INTO students (fname,lname,class,section) VALUES ('$fname','$lname','$class','$section')";
//     $query_run = mysqli_query($conn, $query);

//     if($query_run)
//     {
//         echo $return  = "Successfully Stored";
//     }
//     else
//     {
//         echo $return  = "Something Went Wrong.!";
//     }
// }
