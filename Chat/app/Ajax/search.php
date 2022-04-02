<?php

session_start();
if(isset($_SESSION['user_id'])){
    if(isset($_POST['key'])){
    require "../dbo.php";
    require "../helpers/timeAgo.php";
    $value="{$_POST['key']}%";
    $sql="SELECT * FROM users 
    WHERE username 
    LIKE ? OR name LIKE ?";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$value,$value]);
    if($stmt->rowCount() >0){
        $stmtResult=$stmt->fetchAll();
        foreach($stmtResult as $conversation){
            if($conversation['name']==$_SESSION['name'])continue;
    ?>
    <li class="list-group-item d-flex align-items-center justify-content-between">
    <a href="chat.php?user=<?php echo $conversation['username']; ?>" class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="img/<?php echo $conversation['p_p']; ?>" alt="" srcset="" class="w-10 rounded-circle">
            <p class="m-2"><?php echo $conversation['name']; ?></p>
        </div>
    </a>
    <?php if(lastseen($conversation['last_seen'])=="Active"){?>
    <div title="online">
        <div class="online"></div>
    </div>
    <?php }else{?>
    <div title="online">
        <p class="m-2"><?php echo lastseen($conversation['last_seen']) ?></p>
    </div>
    <?php } ?>
</li>
  <?php }}else{ ?>
<div class="alert alert-primary text-center">
    <p>No Result</p>
</div>
<?php
  } 
}else{
        header("location:../../index.php");
        exit();
}}else{
    header("location:../../index.php");
    exit();
}?>