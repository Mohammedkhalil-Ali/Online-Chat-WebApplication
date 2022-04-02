<?php

function getchat($from,$to,$conn){
    $sql="SELECT * FROM chats
    WHERE (from_id=? AND to_id=?)
    OR (to_id=? AND from_id=?)
    ORDER BY chat_id ASC ";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$from,$to,$from,$to]);
    if($stmt->rowCount()>0){
        $user=$stmt->fetchAll();
        return $user;
    }else{
        $user=[];
        return $user;
    }
    
}