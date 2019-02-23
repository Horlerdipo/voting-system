<?php
require_once("includes/ini.php");
if(isset($_POST['presidential']) && !empty($_POST['presidential'])){
    session_start();

    if (empty($_SESSION['matric_no']) || empty($_SESSION['password'])) {

        header('Content-type: application/json');
        $array = array('result' => "You are not logged in",'gotoPage'=>"http://localhost/voting-system");
        echo json_encode($array);
    }else {
        $matric_no=$users->validate_data($_SESSION['matric_no']);
        $password=$users->validate_data($_SESSION['password']);
    
    
    $sql="SELECT * FROM users WHERE matric_no='{$matric_no}' AND password='{$password}'";
    $result=mysqli_fetch_assoc($database->querydb($sql));
    //print_r($result);
    if($result['voted']==1){

        header('Content-type: application/json');
        $array = array('result' => "This user has already voted before",'gotoPage'=>"http://localhost/voting-system");
        echo json_encode($array);
        die();
    }else{
        $candidate=$_POST['presidential'];
        $sql="INSERT INTO votes ($candidate) VALUES ('$matric_no')";
        if ($database->querydb($sql)) {
            $sql="UPDATE users SET voted='1' WHERE  password='$password' AND matric_no='$matric_no'";
            $database->querydb($sql);
            header('Content-type: application/json');
            $array = array('result' => "Voting Completed",'gotoPage'=>"http://localhost/voting-system");
            echo json_encode($array);
            die();
        }

    }
}
}
?>