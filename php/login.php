<?php

$userID=$_POST['userID'];
$password=md5(trim($_POST['password']));

$db_host ='127.0.0.1';
$db_user='root';
$db_pwd='';
$db_name='user';
$db_port=3306;

$con=mysqli_connect($db_host,$db_user,$db_pwd,$db_name,$db_port);
if(!$con){
    die("error:".mysqli_connect_error());
}

if($userID==null||$password==null){
    echo "<script>alert('請填寫完整的資料！')</script>";
}

$sql='select * from user where userID='."'{$userID}'and Password="."'$password';";
    $res=mysqli_query($con,$sql);
    $row = $res->num_rows;
    if($row!=0){
        session_start();
        $_SESSION['userID'] = $userID;
        header("Refresh:1;url=../main.php");
    }else{
        echo "<script>alert('Password or Username Wrong!');history.go(-1);</script>";
        
    }