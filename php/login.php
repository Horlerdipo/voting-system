<?php
require_once("includes/ini.php");
if (isset($_POST['matric_no']) && !empty($_POST['password']) && isset($_POST['password']) && !empty($_POST['matric_no'])){
    $matric_no=$users->validate_data($_POST['matric_no']);
    $password=$users->validate_data($_POST['password']);

    $sql="SELECT * FROM users WHERE matric_no='{$matric_no}' AND password='{$password}'";
    $result=mysqli_fetch_assoc($database->querydb($sql));

    if (mysqli_num_rows($database->querydb($sql))==1  ) {
        if($result['voted']==0){
        session_start();
        $_SESSION['matric_no']=$matric_no;
        $_SESSION['password']=$password;

        header('Content-type: application/json');
        $array = array('result' => "logged in",'gotoPage'=>"http://localhost/voting-system/vote.html");
        echo json_encode($array);
        }else{
            header('Content-type: application/json');
            $array = array('result' => "This user has already voted");//'gotoPage'=>"http://localhost/voting-system/vote.html");
            echo json_encode($array);
        }
    }else{
        header('Content-type: application/json');
        $array = array('result' => "incorrect input please try again");//'gotoPage'=>"http://localhost/voting-system/register.html");
        echo json_encode($array);
        die();
    }
}else{
    header('Content-type: application/json');
    $array = array('result' => "input the appropriate values");//'gotoPage'=>"http://localhost/voting-system/register.html");
    echo json_encode($array);
    die();
}
?>