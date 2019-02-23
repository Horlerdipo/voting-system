<?php

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
echo generate_string($permitted_chars,10);

$con=mysqli_connect("localhost","phpmyadmin","akinkunmi","voters");
//$result=mysqli_fetch_row(mysqli_query($con,"SELECT * FROM users"));
//print_r($result);


?>