<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Blog website</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Blog website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <?php
          include "../partials/db.php";
          $sql = "SELECT * FROM `blog1` WHERE `blog1`.`fornav` = 'yes'";
          $result = mysqli_query($connect, $sql);
          $num = mysqli_num_rows($result);
          if($num > 0){
              while($row = mysqli_fetch_assoc($result)){
                  echo '<li class="nav-item">
                  <a class="nav-link" href="../listpage?cat='.$row['type'].'">'.$row['type'].'</a>
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
    <div class="container pt-5">
        <?php
        $blog = $_GET['title'];
        include "../partials/db.php";
        $sql1 = "SELECT * FROM `blog1` WHERE `blog1`.`title` = '$blog'";
        $result1 = mysqli_query($connect, $sql1);
        $num1 = mysqli_num_rows($result1);
        if ($num1 > 0) {
            while($row1 = mysqli_fetch_assoc($result1)){
                echo '<div class="card w-75">
                <div class="card-body">
                    <h5 class="card-title">'.$row1['title'].'</h5>
                    <p class="card-text">'.$row1['content'].'</p>
                </div>
            </div>';
            }
        }
        else{
            die("there is some error in fecthing data from database");
        }
        ?>


    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>