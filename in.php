<?php
    session_start();
    $dbhost = 'demo.jlwu.info:1107';
    $dbuser = 'VAI';
    $dbpass = '@VUH5Xi32tAM2yoAm';
    $dbname = 'VAI';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);//連接資料庫
    mysqli_query($conn, "SET NAMES 'utf8'");//設定語系
    mysqli_select_db($conn, $dbname);
    $u_id = $_SESSION["u_id"];
    $number = $_SESSION['username'];
    $count = $_SESSION['comment_amount'];
    $a_id = $_SESSION['article_id'];

    ##### UPDATE每則留言的答案 #####
    for($i=1; $i<=$count; $i++){
        $sql = "UPDATE score SET v_grade = '".$_POST["v$i"]."', a_grade = '".$_POST["a$i"]."', i_sentence = '".$_POST["i$i"]."', incomplete = '".$_POST["in$i"]."' WHERE u_id =  '".$u_id."' and c_id = '".$_POST["c_id$i"]."'";
        mysqli_query($conn,$sql);
    }
    
    ##### UPDATE tag 狀態 #####
    $sql_tag = "UPDATE tag SET tagged = 1 WHERE u_id =  '".$u_id."' and a_id = '".$a_id."'";
    mysqli_query($conn,$sql_tag);
    mysqli_close($conn);
    header("Location: ./tagged.php");
?>