<?php
require_once("includes/ini.php");
 if(isset($_POST['matric_no']) && !empty($_POST['matric_no']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['name']) && !empty($_POST['name'])){
    $matric_no=$_POST['matric_no'];
    $email=$_POST['email'];
    $name=$_POST['name'];

    $sql="SELECT * FROM users WHERE matric_no='{$matric_no}' AND name='{$name}' AND email='{$email}'";

    if(mysqli_num_rows($database->querydb($sql))==1){

        $permitted_chars='0123456789asdfghjklpoiuytrewqzxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        function generate_string($input,$strength=16){
            $input_length=strlen($input);
            $random_string='';
            for($i=0;$i<$strength;$i++){
                $random_character=$input[mt_rand(0,$input_length-1)];
                $random_string.=$random_character;
            }
            return $random_string;  
        }
        $password=generate_string($permitted_chars,12);





        $sql="UPDATE users SET password='{$password}' WHERE name='$name'  AND email='$email' AND matric_no='$matric_no'";

        if ($database->querydb($sql)) {

            header('Content-type: application/json');
            $array = array('result' => "Password Change Successful.Your password is {$password}",'gotoPage'=>"http://localhost/voting-system");
            echo json_encode($array);
            
        }else {
            header('Content-type: application/json');
            $array = array('result' => "Change not successful please try again");//'gotoPage'=>"http://localhost/voting-system");
            echo json_encode($array);
        }
    }else{

        header('Content-type: application/json');
        $array = array('result' => "the user does not exists please try again");//'gotoPage'=>"http://localhost/voting-system/register.html");
        echo json_encode($array);
        die();
    }

 }
?>