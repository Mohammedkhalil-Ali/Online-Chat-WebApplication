<?php

session_start();
if(isset($_SESSION['user_id'])){
    if(isset($_POST['messages']) && isset($_POST['to_id'])){
        $from_id=$_SESSION['user_id'];
        $to_id=$_POST['to_id'];
        $message=$_POST['messages'];
        require "../dbo.php";
        $sql="INSERT INTO chats(from_id,to_id,message)VALUES(?,?,?)";
        $stmt=$conn->prepare($sql);
        $res=$stmt->execute([$from_id,$to_id,$message]);
            if($res){
                $sql2="SELECT * FROM conversations
                WHERE user_1=? AND user_2=?
                OR user_2=? AND user_1=?";
                $stmt2=$conn->prepare($sql2);
                $stmt2->execute([$from_id,$to_id,$from_id,$to_id]);
                define("TIMEZONE","Asia/Baghdad");
                date_default_timezone_set(TIMEZONE);
                $time=date("h:i:s a");
            if($stmt2->rowCount()==0){
                $sql3="INSERT INTO conversations(user_1,user_2)VALUES(?,?)";
                $stmt3=$conn->prepare($sql3);
                $stmt3->execute([$from_id,$to_id]);
            }
            ?>
            <p class="border rounded p-2 mb-1 rtext align-self-end"><?php echo $message;?>
            <small class="d-block"><?php echo $time ?></small>
            </p>
            <?php
        }
    }else{
        header("location:../../index.php");
        exit();
    }}else{
        header("location:../../index.php");
        exit();
    }
