<?php
// this code is for ajax data transfer
include 'partials/db.php';
$sno_for_update = $_POST['s3'];
$title_for_update = $_POST['t3'];
$content_for_update = $_POST['c3'];
$sql_for_update = "UPDATE `blog1` SET `title` = '$title_for_update', `content` = '$content_for_update' WHERE `blog1`.`sno` = '$sno_for_update'";
$result_for_fdelete = mysqli_query($connect, $sql_for_update);
if($sql_for_update){
    $sql_for_updateded = "SELECT * FROM `blog1` WHERE `blog1`.`title` = '$title_for_update'";
    $result_for_updateded = mysqli_query($connect, $sql_for_updateded);
    if($result_for_updateded){
        while($row = mysqli_fetch_assoc($result_for_updateded)){
            echo '<div class="card-header" id="t2">
                '.$row['title'].'
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p id="c2">'.$row['content'].'</p>
                </blockquote>
                <a class="btn btn-primary updates" id="'.$row['sno'].'">Update</a>
                <a class="btn btn-primary deletes" id="'.$row['title'].'">Delete</a>
            </div>';
        }
    }
}
?>