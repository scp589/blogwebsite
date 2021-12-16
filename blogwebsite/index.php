<?php
include "partials/db.php";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sunny.css">

    <title>blog website</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Blog website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
          include "partials/db.php";
          $sql = "SELECT * FROM `blog1` WHERE `blog1`.`fornav` = 'yes'";
          $result = mysqli_query($connect, $sql);
          $num = mysqli_num_rows($result);
          if($num > 0){
              while($row = mysqli_fetch_assoc($result)){
                  echo '<li class="nav-item">
                  <a class="nav-link" href="listpage?cat='.$row['type'].'">'.$row['type'].'</a>
                </li>';
              }
          }
          else{
            die("there is some error in fecthing data from database");
          }
          ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container pt-2 overflow1">
        <div class="row overflow2">
        <h1><span class="badge bg-success">Latest</span></h1>
            <?php
            // include "partials/db.php";
            $sql1 = "SELECT * FROM `blog1` where `blog1`.`latest` = 'yes'";
            $result1 = mysqli_query($connect, $sql1);
            $num1 = mysqli_num_rows($result1);
            if ($num1>0) {
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    echo '<div class="card w-75 mt-5">
                    <div class="card-body">
                        <h5 class="card-title">'.$row1['title'].'</h5>
                        <p class="card-text">'.substr($row1['content'], 0, 400).'.....</p>
                        <a href="mainpage?title='.$row1['title'].'" class="btn btn-primary">Read more</a>
                    </div>
                </div>';
                }
            }
            else{
                die("there is some error in fecthing data from database");
            }
            ?>
        </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9Xhttps://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.jsOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>