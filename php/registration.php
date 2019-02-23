<?php
    require_once("includes/ini.php");
    
    if(isset($_POST['matric_no']) && !empty($_POST['matric_no']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['name']) && !empty($_POST['name'])){
        //USE VLIDATE_DATA FOR HTML ESCAPING
        $matric_no=$users->validate_data($_POST['matric_no']);
        $email=$users->validate_data($_POST['email']);
        $name=$users->validate_data($_POST['name']);
        //CHECK IF USER IS ALREADY IN THE DATABASE
        //echo($matric_no);
        $mail = 'email';
        //create function to generate random strings
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

        $sql="SELECT * FROM users WHERE matric_no='$matric_no'";
        //print_r(mysqli_fetch_assoc($database->querydb($sql)));
        
        
        
        if(mysqli_num_rows($database->querydb($sql))==1){

            
            header('Content-type: application/json');
            $array = array('result' => "the user already exists");//'gotoPage'=>"http://localhost/voting-system/register.html");
            echo json_encode($array);
            

         }else {
             //if user does not exists,use querydb function to insert new user into db
            $sql="SELECT * FROM users WHERE email ='$email'";
             if(mysqli_num_rows($database->querydb($sql))==1){
                 
                 header('Content-type: application/json');
                $array = array('result' => "the user already exists");//'gotoPage'=>"http://localhost/voting-system/register.html");
                echo json_encode($array);
             }else{
             $sql="INSERT INTO users (email,name,matric_no,password,voted) VALUES ('$email','$name','$matric_no','$password',0)";
             $result=$database->querydb($sql);
             if($result){
                 //echo("user entered into db successfully");
                 header('Content-type: application/json');
                $array = array('result' => "registration successful.Your password is {$password}",'gotoPage'=>"http://localhost/voting-system");
                echo json_encode($array);
             }else {
                 echo("server error please try again or conact us");
                 //return false;
                 die("server error".mysqli_errno);
         };
        };


     }
    }
?>