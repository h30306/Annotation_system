<?php

    session_start();
    $dbhost = 'demo.jlwu.info:1107';
    $dbuser = 'VAI';
    $dbpass = '@VUH5Xi32tAM2yoAm';
    $dbname = 'VAI';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) ;//連接資料庫
    mysqli_query($conn, "SET NAMES 'utf8'");//設定語系
    mysqli_select_db($conn, $dbname);

    ##### 判斷是否跳頁進來 #####
    if($_SESSION['username']){
    }else{
        header("Location: ./sign.php");
    }

    ##### 學號session #####
    $number = $_SESSION['username'];

    ##### 查找對應文章並存id進session #####
    $result_article = "SELECT * from article where a_id in (select a_id from user, tag where user.u_number = '" .$number."'and tag.u_id = user.u_id and tag.tagged = 0) LIMIT 1";
    $result_article = mysqli_query($conn, $result_article);
    $result_article = mysqli_fetch_assoc($result_article);
    $_SESSION['article_id'] = $result_article['a_id'];

    ##### 判斷是否還有文章 #####
    if($result_article['a_id'] == ''){?>
        <script language="javascript"> alert('您已標記完成！')</script>";
        <?php
        header("refresh:0 url=./sign.php");
    }
    ?>
    <?php

    ##### 用文章id找對應留言 #####
    $artilce_id = $result_article['a_id'];
    $result_comment = "SELECT * from content where a_id = '" .$artilce_id."'";
    $result_comment = mysqli_query($conn, $result_comment);

    ##### 留言數量存入session ##### 
    $_SESSION["comment_amount"] = mysqli_num_rows($result_comment);

    ##### 進度查詢 #####
    $count = "SELECT COUNT(*) FROM tag, user where user.u_number = '" .$number."' and tag.tagged = 1 and tag.u_id = user.u_id";
    $count = mysqli_query($conn, $count);
    $count = mysqli_fetch_assoc($count);

?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function wait() {
          alert('結果處理中，請勿重新整理畫面或按上一頁，感謝您耐心等候');
        }
    </script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="css/style1.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="css/tagged.css">

    <title>資料標記頁</title>
    <style type="text/css">
        table {
          text-align: left;
          position: relative;
          border-collapse: collapse; 
        }
        th, td {
          padding: 0.25rem;
        }
        tr.red th {
          background: red;
          color: white;
        }
        tr.green th {
          background: green;
          color: white;
        }
        tr.purple th {
          background: purple;
          color: white;
        }
        th {
          background: white;
          position: sticky;
          top: 80px;
          box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }
    </style>

</head>

<body>
    <header class="w3-container w3-top w3-black w3-xlarge w3-padding-16">
        <span class="w3-left w3-padding">NLP Data Annotation</span>
        <div class="w3-padding w3-display-topmiddle">
            <h6>
                目前進度：<?php echo $count["COUNT(*)"] ?>/40 
            </h6>
        </div>
        <div class="w3-display-middle progress" style="width: 150px;">
            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?php echo $count["COUNT(*)"]*2.5 ?>%" aria-valuenow="<?php echo $count["COUNT(*)"]*2.5 ?>" aria-valuemin="0" aria-valuemax="40"> 
            </div> &nbsp;
        </div> 
        <div class="w3-display-right">
            <h5> Hi, <?php echo $number; ?> &nbsp;
            <form action="logout.php" method="Post"> 
                <input type="Submit" name='submit' class="btn btn-danger" value='登出'>&emsp;
            </form>
            </h5> 
        </div>
    </header>
    <br>
    <br>
        <div class="row" style="padding-top: 30px">
            <div class="col-sm-1"></div>
            <div class="col-sm-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="score">文章標題及內文</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>    
                            <td><?php echo $result_article['a_title'];?></td>
                        </tr>
                        <tr>    
                            <td><?php echo $result_article['a_content'];?></td>
                        </tr>
                    </tbody>
                </table>
                
                <form action="in.php" method="post" >
                     <table class="table table-striped table-bordered" align="center">
                        <thead align="center" width="30%"> 
                            <tr>
                                <th scope="col" width="1%" >樓層</th>
                                <th scope="col" width="30%">留言</th>
                                <th scope="col" class="score" width="20%" nowrap="nowrap">正負向<br>無 負向⟶正向<br>0&emsp;&ensp;1&emsp;&ensp;2&emsp;&ensp;3&emsp;&ensp;4&emsp;&ensp;5</th>
                                <th scope="col" class="score" width="20%" nowrap="nowrap">激動程度<br>無 不激動⟶激動<br>0&emsp;&ensp;1&emsp;&ensp;2&emsp;&ensp;3&emsp;&ensp;4&emsp;&ensp;5</th>
                                <th scope="col" class="score" width="20%" nowrap="nowrap">反諷程度<br>&emsp;&ensp;&ensp;&ensp;&emsp;無 程度低⟶程度高<br>0&emsp;&ensp;1&emsp;&ensp;2&emsp;&ensp;3&emsp;&ensp;4&emsp;&ensp;5</th>
                                <th scope="col" class="score" width="25%" nowrap="nowrap">不完整句<br>無 有<br>0 1</th>
                            </tr>
                        </thead>
                        <tbody align="left">
                        <?php
                            for($i=1;$i<=mysqli_num_rows($result_comment);$i++){
                                $rs=mysqli_fetch_row($result_comment);
                        ?>
                        
                            <tr>
                                <td>
                                    <?php echo "[$i]";?>
                                </td>
                                <td>
                                    <?php echo "<input type='hidden' name='c_id$i' value='$rs[0]' checked='true'>";?>
                                    <?php echo $rs[1];?>
                                </td>
                                <td nowrap="nowrap">
                                    <?php echo "<ul><input type='radio' name='v$i' value='0' required>";?>&ensp;
                                    <?php echo "<input type='radio' name='v$i' value='1'>";?>&ensp;
                                    <?php echo "<input type='radio' name='v$i' value='2'>";?>&ensp;
                                    <?php echo "<input type='radio' name='v$i' value='3'>";?>&ensp;
                                    <?php echo "<input type='radio' name='v$i' value='4'>";?>&ensp;
                                    <?php echo "<input type='radio' name='v$i' value='5' checked='true'></ul>";?>
                                </td>
                                <td nowrap="nowrap">
                                    <?php echo "<ul><input type='radio' name='a$i' value='0' required>";?>&ensp;
                                    <?php echo "<input type='radio' name='a$i' value='1'>";?>&ensp;
                                    <?php echo "<input type='radio' name='a$i' value='2'>";?>&ensp;
                                    <?php echo "<input type='radio' name='a$i' value='3'>";?>&ensp;
                                    <?php echo "<input type='radio' name='a$i' value='4'>";?>&ensp;
                                    <?php echo "<input type='radio' name='a$i' value='5' checked='true'></ul>";?>
                                </td>
                                <td nowrap="nowrap">
                                    <?php echo "<ul><input type='radio' name='i$i' value='0' required>";?>&ensp;
                                    <?php echo "<input type='radio' name='i$i' value='1'>";?>&ensp;
                                    <?php echo "<input type='radio' name='i$i' value='2'>";?>&ensp;
                                    <?php echo "<input type='radio' name='i$i' value='3'>";?>&ensp;
                                    <?php echo "<input type='radio' name='i$i' value='4'>";?>&ensp;
                                    <?php echo "<input type='radio' name='i$i' value='5' checked='true'></ul>";?>
                                </td>
                                <td nowrap="nowrap">
                                    <?php echo "<ul><input type='radio' name='in$i' value='0' checked='true'>";?>&ensp;
                                    <?php echo "<input type='radio' name='in$i' value='1'><ul>";?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                     </table>
                     <div align="right">
                     <input onclick="wait()" type="Submit" name='submit' class="btn btn-warning"  value='送出表單'>&emsp;&emsp;&emsp;&emsp;
                     </div>
                </form>
            </div>
        </div>
        <footer class="text-center text-small">
            © 2020 <a href="http://bigdata.scu.edu.tw/">School of Big Data Management</a>, Soochow Univerity
        </footer>
    <!-- </div> -->
</body>

</html>