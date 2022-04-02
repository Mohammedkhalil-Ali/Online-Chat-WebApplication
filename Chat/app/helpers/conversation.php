<?php

function getConversation($userid,$conn){
    $sql="SELECT * FROM conversations WHERE user_1=? OR user_2=? ORDER BY conversation_id DESC";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$userid,$userid]);
    if($stmt->rowCount() > 0){
        $conversations=$stmt->fetchAll();
        $data=[];
        foreach($conversations as $conversation){
            if($conversation['user_1']==$userid){
                $sql1="SELECT * FROM users WHERE user_id=?";
                $stmt1=$conn->prepare($sql1);
                $stmt1->execute([$conversation['user_2']]);
            }else{
                $sql1="SELECT * FROM users WHERE user_id=?";
                $stmt1=$conn->prepare($sql1);
                $stmt1->execute([$conversation['user_1']]);
            }
            $Allconversation=$stmt1->fetchAll();
            array_push($data,$Allconversation[0]);
        }
        return $data;
    }else{
        $data=[];
        return $data;
    }
}