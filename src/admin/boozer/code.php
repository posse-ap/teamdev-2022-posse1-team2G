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


// 二本目元データ
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


// 三本目　詳細モーダル
// checking_viewがセットされていたら　つまり詳細が押されたら？
if (isset($_POST['checking_view'])) {
  $stud_id = $_POST['stud_id'];
  // $checkings = [];

  $query_detail = "SELECT * FROM students WHERE id='$stud_id' ";
  $stmt_detail = $db->prepare($query_detail);
  $stmt_detail->execute();
  $result_detail = $stmt_detail->fetchAll();
  // $query_run = mysqli_query($conn, $query);
  // print_r($result_detail);

  if ($result_detail == true) {
    // foreach ($query_run as $row) {
    //   array_push($result_array, $row);
    // }
    header('Content-type: application/json');
    echo json_encode($result_detail);
  } else {
    echo $return = "詳細画面開けません!";
  }
}

// 三本目元データ
// if (isset($_POST['checking_view'])) {
//   $stud_id = $_POST['stud_id'];
//   $result_array = [];

//   $query = "SELECT * FROM students WHERE id='$stud_id' ";
//   // $query_run = mysqli_query($conn, $query);

//   if (mysqli_num_rows($query_run) > 0) {
//     foreach ($query_run as $row) {
//       array_push($result_array, $row);
//     }
//     header('Content-type: application/json');
//     echo json_encode($result_array);
//   } else {
//     echo $return = "No Record Found.!";
//   }
// }


// 四本目　編集モーダル 三本目（詳細のほぼコピペ）
// checking_editがセットされていたら　つまり編集が押されたら？
if (isset($_POST['checking_edit'])) {
  $stud_id = $_POST['stud_id'];
  // $checkings = [];

  $query_edit = "SELECT * FROM students WHERE id='$stud_id' ";
  $stmt_edit = $db->prepare($query_edit);
  $stmt_edit->execute();
  $result_edit = $stmt_edit->fetchAll();
  // $query_run = mysqli_query($conn, $query);
  // print_r($result_detail);

  if ($result_edit== true) {
    // foreach ($query_run as $row) {
    //   array_push($result_array, $row);
    // }
    header('Content-type: application/json');
    echo json_encode($result_edit);
  } else {
    echo $return = "編集画面開けません!";
  }
}