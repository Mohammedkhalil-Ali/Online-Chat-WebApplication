<?php
session_start();
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
    <title>Document</title>
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">
    <div class="shadow rounded p-4">
    <div class="mb-3 d-flex align-items-center justify-content-center flex-column">
        <img src="./img/message-icon-png.png" alt="" srcset="" class="w-25">
        <h3 class="text-center fs-1 display-4">LOGIN</h3>
    </div>
    <?php
        if(isset($_GET['Success'])){?>
            <div class="alert alert-success text-center" role="alert">
            <?php echo $_GET['Success'];?>
            </div><?php } ?>
            <?php  if(isset($_GET['error'])){?>
            <div class="alert alert-warning text-center" role="alert">
            <?php echo $_GET['error'];?>
            </div><?php } ?>
        <form method="POST" action="./app/http/auths.php">
    <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <button type="submit" class="btn btn-primary" name="LoginBtn">Submit</button>
    <a href="./signupForm.php">Signup</a>
    </form>
    </div>
</body>

</html>