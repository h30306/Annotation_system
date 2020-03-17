<?php
    session_start();
    $dbhost = 'demo.jlwu.info:1107';
    $dbuser = 'VAI';
    $dbpass = '@VUH5Xi32tAM2yoAm';
    $dbname = 'VAI';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);//連接資料庫
    mysqli_query($conn, "SET NAMES 'utf8'");//設定語系
    mysqli_select_db($conn, $dbname);

    $sql = "SELECT * FROM user WHERE u_number = '".$_POST["number"]."'";
    $result = mysqli_query($conn,$sql);
    $row_result = mysqli_fetch_assoc($result);

    if($_POST["number"]){

    	$admin = $row_result['u_number'];
    	if($admin == $_POST["number"]){

            $_SESSION["username"] = $admin;
            $_SESSION["u_id"] = $row_result['u_id'];
            echo "<script>alert('登入後請檢查右上角學號是否正確'); location.href = './tagged.php';</script>";

    	}else{
            echo "<script>alert('請輸入正確的學號！'); location.href = './index.php';</script>";
    	}
    }
    mysqli_close($conn);
?>