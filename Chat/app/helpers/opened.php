<?php

function opened($idfrom,$conn,$chats){
    $open=1;
    foreach($chats as $chat){
        if($chat['opened']==0){
            $sql="UPDATE chats SET
                    opened=?
                    Where from_id=?
                    AND chat_id=?";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute([$open,$idfrom,$chat['chat_id']]);
        }
    }
}