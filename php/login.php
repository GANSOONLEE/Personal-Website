<?php

$userID=$_POST['userID'];
$password=md5(trim($_POST['password']));

$data = json_decode(file_get_contents('.env/data.json'), true);

$db_host = $data->MySQL->db_host;
$db_user= $data->MySQL->db_user;
$db_pwd= $data->MySQL->pwd;
$db_name= $data->MySQL->name;
$db_port= $data->MySQL->port;

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
