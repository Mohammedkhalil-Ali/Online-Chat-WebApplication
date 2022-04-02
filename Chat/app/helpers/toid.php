<?php
session_start();
if(isset($_SESSION['user_id'])){
    if(isset($_POST['toid'])){
    require "../dbo.php";
    $from=$_SESSION['user_id'];
    $to=$_POST['toid'];
    $sql="SELECT * FROM chats
    WHERE to_id=? 
    AND from_id=?
    ORDER BY chat_id ASC";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$from,$to]);
    if($stmt->rowCount()>0){
        $chats=$stmt->fetchAll();
        foreach($chats as $chat){
            if($chat['opened']==0){
                $open1=1;
                $sql1="UPDATE chats SET opened=? WHERE chat_id=?";
                $stmt1=$conn->prepare($sql1);
                $stmt1->execute([$open1,$chat['chat_id']]);
                ?>
            <p class="border rounded p-2 mb-1 ltext"><?php echo $chat['message']; ?>
            <small class="d-block"><?php echo $chat['created_at']; ?></small>
            </p>
            <?php
            }
        }
    }   
}
}else{
    header("../../index.php");
    exit();
}