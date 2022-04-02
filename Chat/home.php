<?php 
session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php?bo");
}else{
    require "app/dbo.php";
    require "app/helpers/help.php";
    require "app/helpers/conversation.php";
    require "app/helpers/timeAgo.php";
    require "app/helpers/lastchat.php";
    $user=getdata($_SESSION['username'],$conn);
    $conversations=getConversation($user['user_id'],$conn);
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
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
             <img src="img/<?php echo $user['p_p'] ?>" alt="" srcset="" class="w-101 rounded-circle me-1">
             <h5><?php echo $user['name'] ?></h5>   
            </div>
            <a href="logout.php" class="btn btn-outline-dark">Logout</a>
        </div>
        <div class="input-group mb-3 mt-2">
            <input type="text" placeholder="Search..." class="form-control" id="searchText">
            <button class="btn btn-primary" id="searchBtn"><i class="fa fa-search"></i></button>
        </div>
        <div>
            <ul class="list-group mvh-50 overflow-auto" id="list-groupid">
                <?php if($conversations){
                    foreach($conversations as $conversation){
                    ?>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <a href="chat.php?user=<?php echo $conversation['username']; ?>">
                        <div class="d-flex align-items-center">
                            <img src="img/<?php echo $conversation['p_p']; ?>" alt="" srcset="" class="w-10 rounded-circle">
                            <p class="m-2"><?php echo $conversation['name']; ?> <br>
                            <small><?php echo "chats : ". lastchat($_SESSION['user_id'],$conversation['user_id'],$conn); ?></small>
                        </p>
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
                <?php }}else{?>
                    <div class="alert alert-primary text-center">
                        <p>No Conversation</p>
                    </div>
                <?php }?>
                
            </ul>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script> 
   $(document).ready(function(){
    $("#searchText").on("input",function(){
        var serchText = $(this).val();
        $.post("app/Ajax/search.php",
        {key:serchText},
        function(data,status){
            $("#list-groupid").html(data);
        })
    })
    $("#searchBtn").on("click",function(){
        var serchText = $("#searchText").val();
        $.post("app/Ajax/search.php",
        {key:serchText},
        function(data,status){
            $("#list-groupid").html(data);
        })
    })
    let lastseen=function(){
    $.get("./app/Ajax/lastseen.ajax.php");
    }

    setInterval(lastseen,1000);

});
</script>
</body>
</html>

<?php } ?>