<?php
use PHPMailer\PHPMailer\PHPMailer;

require  'PHPMailer-6.7.1/src/Exception.php' ;
require  'PHPMailer-6.7.1/src/PHPMailer.php' ;
require  'PHPMailer-6.7.1/src/SMTP.php' ;

$data = json_decode(file_get_contents('.env/data.json'), true);

$db_host = $data->MySQL->db_host;
$db_user= $data->MySQL->db_user;
$db_pwd= $data->MySQL->pwd;
$db_name= $data->MySQL->name;
$db_port= $data->MySQL->port;

$user =$_POST['user'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$con=mysqli_connect($db_host,$db_user,$db_pwd,$db_name);
if(!$con){
    die("error:".mysqli_connect_error());
}

$username=stripslashes(trim($_POST['username']));

$query=mysqli_query($con, "Select * from user where userID='$user'");
$num = mysqli_num_rows($query);
if($num==1){
    echo "<script>alert('用戶名已經存在！');history.go(-1);</script>";
}else{

    $password=md5(trim($_POST['password']));
    $email = trim($_POST['email']);

    $token = md5($username . $password);
    $token_exptime = time() + 60 * 60 * 24;
    $sql = "insert into user (`userID`,`userName`,`Password`,`birthday`,`emailAddress`,`token`,`tokenExpire`,`valid`) values ('$user', '$username', '$password',' ', '$email','$token', '$token_exptime','0')";
    mysqli_query($con, $sql);
    $mail  = new  PHPMailer (true); // Passing `true` enables exceptions
    try{
        
        //服務器配置
        $mail -> CharSet  = "UTF-8" ;                      //設定郵件編碼
        $mail -> SMTPDebug  =  0 ;                         // 調試模式輸出
        $mail -> isSMTP ();                              // 使用SMTP
        $mail -> Host  =  'smtp.gmail.com' ;                 // SMTP服務器
        $mail -> SMTPAuth  =  true ;                       // 允許 SMTP 認證
        $mail -> Username  =  'vincentgan0402@gmail.com' ;                 // SMTP 用戶名 即郵箱的用戶名
        $mail -> Password  =  'qgmbvozhalbqsrrv' ;             // SMTP 密碼 部分郵箱是授權碼(例如163郵箱)
        $mail -> SMTPSecure  =  'ssl' ;                     // 允許 TLS 或者ssl協議
        $mail -> Port  =  465 ;                             // 服務器端口 25 或者465 具體要看郵箱服務器支持

        $mail -> setFrom ('vincentgan0402@gmail.com');   //發件人
        $mail -> addAddress ('axun0402@gmail.com');   // 收件人
        //$mail->addAddress('ellen@example.com'); // 可添加多個收件人
        //$mail -> addReplyTo ($email, 'info' );  //回复的時候回复給哪個郵箱 建議和發件人一致
        //$mail->addCC('cc@example.com'); //抄送
        //$mail->addBCC('bcc@example.com'); //密送
        
        //發送附件
        // $mail->addAttachment('../xy.zip'); // 添加附件
        // $mail->addAttachment('../thumb-1.jpg', 'new.jpg'); // 發送附件並且重命名

        //Content
        $mail -> isHTML ( true );                                   // 是否以HTML文檔格式發送 發送後客戶端可直接顯示對應HTML內容
        $mail -> Subject  =  '用戶帳號激活';
        $mail -> Body    =  "親愛的".$username."：<br/>感謝您在我站註冊了新帳號。<br/>請點擊連結激活您的帳號。<br/> 
        <a href='http://axun0402.epizy.com/active.php?verify=".$token."&userID=".$user."' target='_blank'>http://axun0402.epizy.com/active.php?verify=".$token."&userID=".$user."</a><br/> 
        如果以上連結無法點擊，請將它複製到你的瀏覽器地址欄中進入訪問，該連結24小時內有效。"; 
        $mail -> AltBody  =  '如果郵件客戶端不支持HTML則顯示此內容' ;
        $mail -> send ();
        echo  '郵件發送成功' ;
        header("Refresh:1;url=./index.html");
    } catch ( Exception $e ) {
        echo  '郵件發送失敗: ' ,  $mail -> ErrorInfo ;
    }
}
