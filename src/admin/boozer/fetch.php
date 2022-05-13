<?php 
require('../../dbconnect.php');
// $conn = mysqli_connect("localhost","root","","phpcrud");
$sql = 'SELECT * FROM students';
$stmt = $db->prepare($sql);
$stmt->execute();
$result_array = $stmt->fetchAll();
// print_r($result_array);

// $query = "SELECT * FROM students";
// $query_run = mysqli_query($conn, $query);
// $result_array = [];

// if(mysqli_num_rows($query_run) > 0)
// {
//     foreach($query_run as $row)
//     {
//         array_push($result_array, $row);
//     }
//     header('Content-type: application/json');
//     echo json_encode($result_array);
// }
// else
// {
//     echo $return = "<h4>No Record Found</h4>";
// }

if ($result_array == true)
{
    // foreach($result_array as $result)
    // {
    //   // print_r($result_);
    //     array_push($result_array, $result);
    // }
    header('Content-type: application/json');
    echo json_encode($result_array);
}
else
{
    echo $return = "<h4>No Record Found</h4>";
}
