<!-- <?php
#require './vendor/autoload.php';
?> -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="Howard W. Chung">
    <title>資料標記</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>
<body class="text-center w3-light-grey">
    <div class="w3-main w3-content" style="max-width:1600px;margin-top:83px">
        <header class="w3-container w3-top w3-black w3-xlarge w3-padding-16">
            <span class="w3-left w3-padding">NLP Data Annotation</span>
        </header>
            <br>
            <h1><span class="text-center badge badge badge-secondary">108-2 資料標記作業</span></h1>
            <br>
            <div class="spinner-grow text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-success" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-info" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-dark" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <br>
            <br>
            <form action="logincheck.php" method="Post">
            <span class="text-center" style="font-size: 18px">請輸入學號及密碼開始做作業！</span><br><br>
                學號：<input type="Text" name="number" id="number" required="required" name="number" maxlength="8">
                <br>
                <br>
                密碼：<input type="password" name="password" id="password" required="required" name="password" maxlength="10">
                <br>
                <br>
                <input type="Submit" name="submit" class="btn btn-warning" value="開始標記">
            </form>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <footer class="text-center text-small">
                <p><a href="https://github.com/h30306">Howard </a>from <a href="http://bigdata.scu.edu.tw/">NLP LAB at SCU</a> © 2020 </p>
            </footer>
    <div>
</body>
</html>




