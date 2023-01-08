<?php

$data = json_decode(file_get_contents('../.env/data.json'), true);

$db_host = $data["MySQL"]["db_host"];
$db_user= $data["MySQL"]["db_user"];
$db_pwd= $data["MySQL"]["db_pwd"];
$db_name= $data["MySQL"]["db_name"];
$db_port= $data["MySQL"]["db_port"];

$con=mysqli_connect($db_host,$db_user,$db_pwd,$db_name,$db_port);
if(!$con){
    die("error:".mysqli_connect_error());
}

$verify = stripslashes(trim($_GET['verify']));
$user = $_GET['userID'];
$nowtime = time(); 

$query = mysqli_query($con, "select userID,tokenExpire from user where valid='0' and  
`token`='$verify'"); 
$row = mysqli_fetch_array($query); 
if($row){ 
    if($nowtime<$row['token_expire']){ //24hour 
        $msg = '您的激活有效期已過，請登錄您的帳號重新發送激活郵件.'; 
    }else{ 
        mysqli_query($con, "update user set valid=1 where userID='$user'"); 
        if(mysqli_affected_rows($con)!=1) die(0); 
        $msg = '激活成功！'; 
    } 
}else{ 
    $msg = 'error.';     
} 
echo $msg; 