<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style4.css">
    <title>Document</title>
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">
    <div class="shadow rounded p-4">
    <div class="mb-3 d-flex align-items-center justify-content-center flex-column">
        <img src="./img/message-icon-png.png" alt="" srcset="" class="w-25">
        <h3 class="text-center fs-1 display-4">Signup</h3>
    </div>
    <?php
        if(isset($_GET['error'])){?>
            <div class="alert alert-warning text-center" role="alert">
            <?php echo $_GET['error'];?>
            </div><?php } ?>
          <?php if(isset($_GET['name'])){
              $name=$_GET['name'];
          }else{$name="";}?>
          <?php if(isset($_GET['username'])){
              $username=$_GET['username'];
          }else{$username="";}?>
            
       
        <form method="POST" action="app/http/signup.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Name :</label>
        <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Username :</label>
        <input type="text" class="form-control" name="user"  value="<?php echo $username ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="pwd">
    </div>
    <div class="mb-3">
        <label class="form-label">Profile Picture</label>
        <input type="file" class="form-control" name="file">
    </div>
    <button type="submit" class="btn btn-primary" name="signupBtn">Submit</button>
    <a href="./index.php">Login</a>
    </form>
    </div>
</body>

</html>