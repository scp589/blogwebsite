<?php
session_start();
if(!isset($_SESSION['logedin']) || $_SESSION['logedin']!=true){
  header("location: index.php");
  exit;
}
$multi_delete_success = false;
// start deleting multi blog
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'partials/db.php';
   if(isset($_POST['deletemulti'])){
       $all_id = $_POST['did'];
       $extract_id = implode(',', $all_id);
       
    //    $sql_for_delete_multi = "DELETE FROM `blog1` WHERE `blog1`.`sno` = IN ($extract_id)"; this is wrong for multipule value
       $sql_for_delete_multi = "DELETE FROM `blog1` WHERE `blog1`.`sno` IN ($extract_id)"; // this riht way
       $result_for_delete_multi = mysqli_query($connect, $sql_for_delete_multi);
       if($result_for_delete_multi){
           $multi_delete_success = true;
       }
       else{
           echo "this is eerror".mysqli_error($connect);
       }
   }
}
// end deleting multiblog
?>
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
                        <a class="nav-link active" aria-current="page" href="main.php">Home</a>
                    </li>
                    <?php
              require "partials/db.php";
              // start of all blog
              $sqlforallblog = "SELECT * FROM `blog1`";
              $result_for_all_blog = mysqli_query($connect, $sqlforallblog);
              // end of all blog
              // start of active link for all blog
              $active_for_link = "";
              if(!isset($_GET['type'])){
                  $active_for_link = "active";
              }
              // end of active link for all blog
              if($result_for_all_blog){
                $num_for_all_blog = mysqli_num_rows($result_for_all_blog);
              echo '<li class="nav-item">
              <a class="nav-link '.$active_for_link.'" href="main.php">all blog
              <span class="badge bg-secondary">'.$num_for_all_blog.'</span></a>
          </li>';
              }
              else {
                echo "there is some problem -----> ".mysqli_error($connect);
              }
              //end of all blog
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
              $row_for_latest = mysqli_fetch_assoc($result_for_latest);
              if($result_for_latest){
                $num_for_latest = mysqli_num_rows($result_for_latest);
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
                        <a class="nav-link" href="createblog.php">create new blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logedout.php">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if($multi_delete_success == true){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        your selected blog has been deleted
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
     $multi_delete_success = false;
    }
    ?>
    <div class="container pt-3">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for question.."
            title="Type in a name">
    </div>
    <div class="container pt-3" id="myUL">
        <form action="main.php" method="post">
            <div class="row justify-content-end stack">
                <span class="my-span"><button class="btn btn-danger my-1" name="deletemulti" type="submit">DELETE</button></span>
                <span class="my-span"><a class="btn btn-primary my-1" onclick="selectmulti()">Select multipule</a></span>
            </div>
            <?php
        include "partials/db.php";
        $sql1 = "SELECT * FROM `blog1`";
        $result1 = mysqli_query($connect, $sql1);
        if ($result1) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                echo '<div class="card mb-3">
                <h5 class="card-header">Posted on '.$row1['dt'].'</h5>
                <div class="card-body">
                    <h5 class="card-title">'.$row1['title'].'</h5>
                    <p class="card-text">'.substr($row1['content'],0,400).'</p>
                    <a href="single.php?title='.$row1['title'].'" class="btn btn-primary">Read more</a>
                    <span class="check-in"><input type="checkbox" value="'.$row1['sno'].'" name="did[]"></span>
                </div>
            </div>';
            }
        }
        else{
            die("there is some error in fetching data from database");
        }
        ?>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
    <script>
        //start of search script
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByClassName("card");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("card-title")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    //end of search script
    check_in = document.getElementsByClassName("check-in");
    Array.from(check_in).forEach((element)=>{
        element.style.display = "none";
    });
    function selectmulti(){
        Array.from(check_in).forEach((element)=>{
            if(element.style.display == "none"){
            element.style.display = "inline-block";
            }
            else{
                element.style.display = "none";
            }
        });
    }
    </script>
</body>

</html>