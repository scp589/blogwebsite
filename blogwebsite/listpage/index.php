<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sunny.css">


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
                  <a class="nav-link" href="?cat='.$row['type'].'">'.$row['type'].'</a>
                </li>';
              }
          }
          ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container pt-3">
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for question.." title="Type in a name">
    </div>
    <div class="container pt-3" id="myUL">
        <?php
        $cat = $_GET['cat'];
        include "../partials/db.php";
        $sql1 = "SELECT * FROM `blog1` WHERE `blog1`.`type` = '$cat'";
        $result1 = mysqli_query($connect, $sql1);
        if ($result1) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                echo '<div class="card mb-3">
                <h5 class="card-header">Posted on '.$row1['dt'].'</h5>
                <div class="card-body">
                    <h5 class="card-title">'.$row1['title'].'</h5>
                    <p class="card-text">'.substr($row1['content'],0,400).'</p>
                    <a href="../mainpage?title='.$row1['title'].'" class="btn btn-primary">Read more</a>
                </div>
            </div>';
            }
        }
        else{
            die("there is some error in fetching data from database");
        }
        ?>
    </div>

    <script src="../js/jquery-3.6.0.js"></script>
    <script src="search.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>