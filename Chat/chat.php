<?php

session_start();
if(isset($_SESSION['user_id'])){
    if(isset($_GET['user'])){
        $from_id=$_SESSION['user_id'];
        $to_id=$_GET['user'];
        require "app/dbo.php";
        require "app/helpers/help.php";
        require "app/helpers/conversation.php";
        require "app/helpers/timeAgo.php";
        require "app/helpers/conversion.php";
        require "app/helpers/opened.php";
        $chatWith=getdata($_GET['user'],$conn);
        $chats=getchat($from_id,$chatWith['user_id'],$conn);
        opened($chatWith['user_id'],$conn,$chats);
        ?>

        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body class="vh-100 d-flex justify-content-center align-items-center">
    <div class="shadow p-4 w-400">
        <div>
            <a href="home.php">Back</a>
        </div>
        <div class="d-flex align-items-center">
            <img src="./img/<?php echo $chatWith['p_p'] ?>" alt="" srcset="" class="w-101 rounded-circle">
            <h3 class="display-6 fs-4"><?php echo $chatWith['name'] ?> <br>
                <div class="d-flex align-items-center">
                <?php if(lastseen($chatWith['last_seen'])=="Active"){?>
                <div class="online"></div><br>
                <small class="fs-6 d-block p-1">Online</small>
                <?php }else{?>
                <small class="fs-6 d-block p-1"><?php echo lastseen($chatWith['last_seen']) ?></small>
                <?php } ?>
                </div>
            </h3>
        </div>
        <?php if($chats){ ?>
            
        <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatbox">
            <?php foreach($chats as $chat){
                if($chat['from_id']==$from_id){?>
            <p class="border rounded p-2 mb-1 rtext align-self-end"><?php echo $chat['message'];?>
            <small class="d-block"><?php echo $chat['created_at']; ?></small>
            </p>
            <?php }else{ ?>
            <p class="border rounded p-2 mb-1 ltext"><?php echo $chat['message']; ?>
            <small class="d-block"><?php echo $chat['created_at']; ?></small>
            </p>
            <?php }} ?>
        </div> 
        <?php } ?>
        <div class="input-group mb-3 mt-2">
            <textarea name="" class="form-control tArea" cols="1" rows="1" id="message"></textarea>
            <button class="btn btn-primary" id="searchBtn"><i class="fa fa-send" id="sendBtn"></i></button>
        </div>   
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script> 
  let scrolup=function(){
      const chatbox=document.getElementById("chatbox");
      chatbox.scrollTop=chatbox.scrollHeight;
  }
  
   $(document).ready(function(){
    let updateForm=function(){
        $.post("app/helpers/toid.php",{
            toid:<?php echo $chatWith['user_id']; ?>
        },function(data,statu){
            $("#chatbox").append(data);
            scrolup();
        }
        )}

    $("#sendBtn").on("click",function(){
        var message=$("#message").val();
        if(message=="")return;
        $.post("app/Ajax/insert.php",{
            messages:message,
            to_id:<?php echo $chatWith['user_id']; ?>
        },function(data,statu){
            $("#message").val("");
            $("#chatbox").append(data);
            scrolup();
        })
    })
    scrolup();
    updateForm();
    let lastseen=function(){
    $.get("./app/Ajax/lastseen.ajax.php");
    }
    setInterval(lastseen,1000);
    setInterval(updateForm,500);

});
</script>

</body>
</html>
    
<?php }else{
    header("location:../../index.php");
    exit();
}}else{
    header("location:../../index.php");
    exit();
}