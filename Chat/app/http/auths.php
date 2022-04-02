<?php
if(isset($_POST['username']) &&
isset($_POST['password'])){

# database connection file
include '../dbo.php';

# get data from POST request and store them in var
$password = $_POST['password'];
$username = $_POST['username'];

$sql1="SELECT * FROM users WHERE username=?";
$stmt2=$conn->prepare($sql1);
$stmt2->execute([$username]);
$stmt3=$stmt2->rowCount();
if($stmt3==1){
    $users=$stmt2->fetch();
    if($users['username']==$username){
        if(password_verify($password,$users['password'])){
            session_start();
            $_SESSION['username'] = $users['username'];
            $_SESSION['name'] = $users['name'];
            $_SESSION['user_id'] = $users['user_id'];

            # redirect to 'home.php'
            header("Location: ../../home.php");
        }else{
        # error message
        $em = "Incorect Username or password";

        # redirect to 'index.php' and passing error message
        header("Location: ../../index.php?error=$em");   
    }
}else{
    # error message
    $em = "Incorect Username or password";

    # redirect to 'index.php' and passing error message
    header("Location: ../../index.php?error=$em");
  }
}else{
    # error message
    $em = "Incorect Username or password";

    # redirect to 'index.php' and passing error message
    header("Location: ../../index.php?error=$em");
  }
    
}else {
header("Location: ../../index.php");
exit;
}