<?php include("config.php"); ?>

<?php
    if($_POST["number"] && $_POST["password"]){

        session_start();
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);//連接資料庫
        mysqli_query($conn, "SET NAMES 'utf8'");//設定語系
        mysqli_select_db($conn, $dbname);

        ##### 用帳號連資料庫 #####
        $sql = "SELECT * FROM user WHERE u_number = '".$_POST["number"]."'";
        $result = mysqli_query($conn,$sql);
        $row_result = mysqli_fetch_assoc($result);

        $admin = $row_result["u_number"];
        $password = $row_result["u_password"];

        if($admin == $_POST["number"] && $password == $_POST["password"]){

            $_SESSION["username"] = $admin;
            $_SESSION["u_id"] = $row_result["u_id"];
            
            echo "<script>location.href = './tagged.php';</script>";

        }else{

            echo "<script>alert('請輸入正確的學號、密碼！'); location.href = './index.php';</script>";

        }

    }else{

        echo "<script>alert('請輸入學號、密碼！'); location.href = './index.php';</script>";

    }
    mysqli_close($conn);
?>
