<?php
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

    session_start();
    $userID = $_SESSION['userID'];

    $sql='select userName from user where userID='."'{$userID}';";
    $res=mysqli_query($con,$sql);

    

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="css/main.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <ul class="links">
            <a><li class="link">首頁</li></a>
            <a><li class="link">測試</li></a>
            <a><li class="link">測試</li></a>
        </ul>
        <div class="logo">
            <img src="">
            <p class="username">
                <?php
                    if (mysqli_num_rows($res) >= 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            echo $row['userName'];
                        }
                    }else{
                        echo 'unknown';
                    }
                ?>
            </p>
        </div>
        <div class="setting">
            <i class="mode"></i>
            <i class="setting"></i>
        </div>
    </div>
</html>
