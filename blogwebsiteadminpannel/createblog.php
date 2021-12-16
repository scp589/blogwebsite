<?php
session_start();
if(!isset($_SESSION['logedin']) || $_SESSION['logedin']!=true){
  header("location: index.php");
  exit;
}
$save = false;
?>
<!-- start of saving data in to database -->
<?php
include 'partials/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // here condition for new categry add
  if(isset($_POST['addnewcategry'])){
      $add_new_categry = $_POST['addnewcategry'];
      if($add_new_categry == ""){
        $blog_title = $_POST['blogtitle'];
        $blog_content = $_POST['content'];
        $add_latest = $_POST['latest'];
        $typed = $_POST['addcategary'];
        $nav_add = $_POST['categry'];
        $sql_for_save_data  = "INSERT INTO `blog1` (`title`, `content`, `latest`, `type`, `fornav`, `dt`) VALUES ('$blog_title', '$blog_content', '$add_latest', '$typed', '$nav_add', current_timestamp())";
        $result_for_save_data = mysqli_query($connect, $sql_for_save_data);
        if($result_for_save_data){
            $save = true;
        }
      }
      else{
        $blog_title1 = $_POST['blogtitle'];
        $blog_content1 = $_POST['content'];
        $add_latest1 = $_POST['latest'];
        $typed1 = $_POST['addnewcategry'];
        $nav_add1 = $_POST['categry'];
        $sql_for_save_data1  = "INSERT INTO `blog1` (`title`, `content`, `latest`, `type`, `fornav`, `dt`) VALUES ('$blog_title1', '$blog_content1', '$add_latest1', '$typed1', '$nav_add1', current_timestamp())";
        $result_for_save_data1 = mysqli_query($connect, $sql_for_save_data1);
        if($result_for_save_data1){
            $save = true;
        }  
      }
 } 
}
?>
<!-- end of saving data in to database -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sunny.css">
    <title>Blogwebsite admin</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php $name = $_SESSION['username']; echo "Admin $name";?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="main.php">Home</a>
                    </li>
                    <?php
              require "partials/db.php";
              // start of all blog finding number
              $sqlforallblog = "SELECT * FROM `blog1`";
              $result_for_all_blog = mysqli_query($connect, $sqlforallblog);
              if($result_for_all_blog){
                $num_for_all_blog = mysqli_num_rows($result_for_all_blog);
              echo '<li class="nav-item">
              <a class="nav-link" href="main.php">all blog
              <span class="badge bg-secondary">'.$num_for_all_blog.'</span></a>
          </li>';
              }
              else {
                echo "there is some problem -----> ".mysqli_error($connect);
              }
              //end of all blog finding number
              $sql = "SELECT * FROM `blog1` WHERE `blog1`.`fornav` = 'yes'";
              $result = mysqli_query($connect, $sql);
              if($result){
                while($row = mysqli_fetch_assoc($result)){
                  //for fetching the number of blogs
              $type = $row['type'];
              $sql1 = "SELECT * FROM `blog1` WHERE `blog1`.`type` = '$type'";
              $result1 = mysqli_query($connect, $sql1);
                  $num = mysqli_num_rows($result1);
                  echo '<li class="nav-item">
                  <a class="nav-link" href="forblogtype.php?type='.$row['type'].'">'.$row['type'].'<span class="badge bg-secondary">'.$num.'</span></a>    
                </li>';
                }
              }
              else{
                echo "there is some problem ----->".mysqli_error($connect);
              }
              // strat of latest
              $sql_for_latest = "SELECT * FROM `blog1` WHERE `blog1`.`latest` = 'yes'";
              $result_for_latest = mysqli_query($connect, $sql_for_latest);
              if($result_for_latest){
                $num_for_latest = mysqli_num_rows($result_for_latest);
                $row_for_latest = mysqli_fetch_assoc($result_for_latest);
                echo '<li class="nav-item">
                <a class="nav-link" href="forblogtype.php?latest='.$row_for_latest['latest'].'">latest
                <span class="badge bg-secondary">'.$num_for_latest.'</span></a>
            </li>';
              }
              else {
                echo "there is some problem -----> ".mysqli_error($connect);
              }
              //end of latest
              ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="createblog.php">create new blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logedout.php">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if($save == true){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         your data have been save
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      $save = false;
    }
    ?>
    <div class="container pt-5">
        <form method="post" action="createblog.php">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Blog title</label>
                        <input type="text" class="form-control" id="blogtitle" aria-describedby="emailHelp"
                            name="blogtitle">
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="write your blog here" id="floatingTextarea2"
                            style="height: 100px" name="content"></textarea>
                        <label for="floatingTextarea2">write your blog here</label>
                    </div>
                    <div class="form-check mb-3">
                        <h5>do you want to add this blog in navbar</h5>
                       <input type="radio" name="categry" value="yes"> yes
                       <input type="radio" name="categry" value="no" checked> no
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 pt-4">
                    <div class="form-check mb-3">
                        <h5 class="h5 display1">do yo want to add this blog in latest list</h5>
                        <input type="radio" name="latest" value="yes"> yes
                        <input type="radio" name="latest" value="no" checked> no
                    </div>
                    <div class="row">
                        <div class="col">
                            <select id="selecte1" name="addcategary" class="form-select"
                                aria-label="Default select example">
                                <option selected>Select blog Type</option>
                                <?php
                                // include 'partial/db.php';
                                $sql_for_select = "SELECT * FROM `blog1` WHERE `blog1`.`fornav` = 'yes'";
                                $result_for_select = mysqli_query($connect, $sql_for_select);
                                while($row_for_select = mysqli_fetch_assoc($result_for_select)){
                                    echo '<option value="'.$row_for_select['type'].'">'.$row_for_select['type'].'</option>';
                                }
                                ?>
                                <!-- <option value="php">php</option>
                                <option value="html">html</option> -->
                            </select>
                            <h4 class="text-center mb-0">or</h4>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Add a new type of blog</label>
                                <input type="text" class="form-control" id="addnewcategry" aria-describedby="emailHelp"
                                    name="addnewcategry">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.6.0.js"></script>

</html>