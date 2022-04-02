<?php

function lastchat($from,$to,$conn){
    $sql="SELECT * FROM chats
    WHERE (from_id=? AND to_id=?)
    OR (to_id=? AND from_id=?)
    ORDER BY chat_id DESC LIMIT 1 ";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$from,$to,$from,$to]);
    if($stmt->rowCount()>0){
        $user=$stmt->fetch();
        return $user['message'];
    }else{
        $user=[];
        return $user;
    }
    
}