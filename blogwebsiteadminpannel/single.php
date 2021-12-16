<?php
session_start();
if(!isset($_SESSION['logedin']) || $_SESSION['logedin']!=true){
  header("location: index.php");
  exit;
}
$delete = false;
$update = false;
//start code for update blog
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'partials/db.php';
    if(isset($_POST['snoe2'])){
        $sno_for_update = $_POST['snoe2'];
        $title_for_update = $_POST['q2'];
        $content_for_update = $_POST['content2'];
        $sql_for_update = "UPDATE `blog1` SET `title` = '$title_for_update', `content` = '$content_for_update' WHERE `blog1`.`sno` = '$sno_for_update'";
        $result_for_update = mysqli_query($connect, $sql_for_update);
        if($result_for_update){
            header('location: single.php?title='.$title_for_update.'');
            $update = true;
        }
    }

    //start of delete code 
    if(isset($_POST['snoe'])){
        $sno_for_delete = $_POST['snoe'];
        // $title_for_delete = $_POST['q'];
        // $content_for_delete = $_POST['content'];
        $sql_for_delete = "DELETE FROM `blog1` WHERE `blog1`.`title` = '$sno_for_delete'";
        $result_for_delete = mysqli_query($connect, $sql_for_delete);
        if($result_for_delete){
            // header('location: single.php');
            $delete = true;
        }
    }
    //end of delete code 

 }
//end code for update blog 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sunny.css">
    <title>Blog website adminpannel</title>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <?php
              require "partials/db.php";
              // start of all blog
              $sqlforallblog = "SELECT * FROM `blog1`";
              $result_for_all_blog = mysqli_query($connect, $sqlforallblog);
              if($result_for_all_blog){
                $num_for_all_blog = mysqli_num_rows($result_for_all_blog);
              echo '<li class="nav-item">
              <a class="nav-link" href="#">all blog
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
              if($result_for_latest){
                $num_for_latest = mysqli_num_rows($result_for_latest);
                echo '<li class="nav-item">
                <a class="nav-link" href="forblogtype.php?latest=yes">latest
                <span class="badge bg-secondary">'.$num_for_latest.'</span></a>
            </li>';
              }
              else {
                echo "there is some problem -----> ".mysqli_error($connect);
              }
              //end of latest
              ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">create new blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logedout">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- this is for javascript ajax code -->
    <!-- <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertd">
        <strong>your blog is updated succesfully!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> -->
<!-- this alert is for php code -->
<?php
if($update == true){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>your blog is updated succesfully!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($delete == true){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>your blog is delete succesfully!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
    <div class="container pt-3">
        <?php
        if(isset($_GET['title'])){
            $title = $_GET['title'];
            $sql_for_data = "SELECT * FROM `blog1` WHERE `blog1`.`title` = '$title'";
            $result_for_data = mysqli_query($connect, $sql_for_data);
            $num_for_data = mysqli_num_rows($result_for_data);
            if($num_for_data>0){
                //start finding the server type
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){   
                    $url = "https://";   
                }
              else  {
                 $url = "http://localhost/"; 
                 $url.= $_SERVER['REQUEST_URI'];     
               }
                 //end the finding url type
                while($row = mysqli_fetch_assoc($result_for_data)){
                    echo '<div class="card" id = "h">
                    <div class="card-header" id="t2">
                        '.$row['title'].'
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p id="c2">'.$row['content'].'</p>
                        </blockquote>
                        <a class="btn btn-primary updates" id="'.$row['sno'].'">Update</a>
                        <a class="btn btn-primary deletes" id="'.$row['title'].'">Delete</a>
                    </div>
                </div>';
                }
            }
            else{
                header('location: main.php');
            }
        }
        //start finding blog to delete code
        
        //end finding blog to delete
        ?>
        <!-- <div class="card">

        </div> -->
        <!-- Modal -->
        <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="single.php" method="post">
                        <input type="hidden" name="snoe" id="snoe">
                        <div class="modal-header">
                            <h5 class="modal-title" id="q">question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="content">
                            content
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Want to update the blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="single.php" method="post">
                    <input type="hidden" name="snoe2" id="snoe2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Ouestion</label>
                        <input type="text" class="form-control" id="q2" name="q2" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">content</label>
                        <textarea class="form-control" id="content2" name="content2" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="updatet">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
delete1 = document.getElementsByClassName('deletes')[0];
delete1.addEventListener("click", (e) => {
    t2 = document.getElementById('t2').innerText;
    c2 = document.getElementById('c2').innerText;
    d2 = e.target.id;
    console.log(d2);
    q = document.getElementById('q').innerText = t2;
    c = document.getElementById('content').innerText = c2;
    snoe = document.getElementById('snoe').value = e.target.id;
    $("#deletemodal").modal("toggle")
});
update1 = document.getElementsByClassName('updates')[0];
update1.addEventListener("click", (e) => {
    t2 = document.getElementById('t2').innerText;
    c2 = document.getElementById('c2').innerText;
    d2 = e.target.id;
    console.log(d2);
    q2 = document.getElementById('q2').value = t2;
    c2 = document.getElementById('content2').value = c2;
    snoe2 = document.getElementById('snoe2').value = e.target.id;
    $("#updateemodal").modal("toggle")
});

//start update code by javascript
// var b = document.getElementById('updatet');
// b.addEventListener("click", function() {
//     console.log('click');
//     var snoe3 = $('#snoe2').val();
//     var q3 = $('#q2').val();
//     var content3 = $('#content2').val();
//     try {
//         $.post('update.php', {
//         s3: snoe3,
//         t3: q3,
//         c3: content3
//     }, function (data, status) {
//         document.getElementById("h").innerHTML = data;
//     }).then(()=>{
//         document.getElementById("alertd").style.display = "block";
//         $("#updateemodal").modal("toggle");
//     });
//     } catch (error) {
//         console.log("there is an error" + error);
//     }
    
// });
// end update code by javascript
</script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.6.0.js"></script>

</html>