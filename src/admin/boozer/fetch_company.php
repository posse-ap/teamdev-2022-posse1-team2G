<?php

require('../../dbconnect.php');

if (!empty($_GET['input'])) {
    $input = $_GET['input'];
    // $id = $_GET['id'];
    // $fname = $_GET['fnamr'];
    // $lname = $_GET['lname'];
    // $class = $_GET['class'];
    // $section = $_GET['section'];
    $sql = "SELECT * FROM students WHERE fname LIKE '%{$input}%' OR lname LIKE '%{$input}%'";
    // $sql = 'SELECT * FROM students';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
    // $output = [];

    // $output .= '
    // <tr> +
    //         <td class="stud_id">' . $result_array['id'] . '</td>
    //                             <td>' . $result_array['fname'] . '</td>\
    //                             <td>' . $result_array['lname'] . '</td>\
    //                             <td>' . $result_array['class'] . '</td>\
    //                             <td>' . $result_array['section'] . '</td>\
    //                             <td>\
    //                                 <a href="#" class="badge btn-info view_btn">VIEW</a>\
    //                                 <a href="#" class="badge btn-primary edit_btn">EDIT</a>\
    //                                 <a href="#" class="badge btn-danger delete_btn">Delete</a>\
    //                             </td>\
    //                         </tr>
    // ';


    // print_r($result_array);
} else {
    // $input = $_GET['input'];
    $sql = "SELECT * FROM students";
    // $sql = 'SELECT * FROM students';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
    // $output .= '<tr>
    //    <td colspan="5">No Data Found</td>
    //   </tr>';
}
// {
//     echo $output;
// }




if ($result_array == true) {
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo $return = "<h4>No Record Found</h4>";
}
