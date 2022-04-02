<?php
if(isset($_POST['signupBtn'])){
    $name=$_POST['name'];
    $username=$_POST['user'];
    $password=$_POST['pwd'];
    $file=$_FILES['file'];

    require "../dbo.php";
    $data="name=".$name."&username=".$username;
    if(empty($name)){
        $em="Name is Required";
        header("location:../../signupForm.php?error=$em&$data");
        exit();
    }else{
        if(empty($username)){
            $em="username is Required";
            header("location:../../signupForm.php?error=$em&$data");
            exit();
        }else{
            if(empty($password)){
                $em="password is Required";
                header("location:../../signupForm.php?error=$em&$data");
                exit();
            }else{
                $sql="SELECT * FROM users WHERE username=?";
                $stmt=$conn->prepare($sql);
                $stmt->execute([$username]);
                if($stmt->rowCount()==0){
                    if(isset($_FILES['file'])){
                        $imgname=$file['name'];
                        $imgextention=strtolower(pathinfo($imgname,PATHINFO_EXTENSION));
                        $allowed=["png","jpg","jpeg","svg","gif"];
                        if($file['error']===0){
                            if(in_array($imgextention,$allowed)){
                                $imgName=$username.".".$imgextention;
                                $destination="../../img/".$imgName;
                                move_uploaded_file($file['tmp_name'],$destination);
                            }else{
                                $em="Img Not Allowed";
                                header("location:../../signupForm.php?error=$em&$data");
                                exit();
                            }
                        }
                    }
                    $newPass=password_hash($password,PASSWORD_DEFAULT);
                    if(isset($imgName)){
                        $sql="INSERT INTO users(name,username,password,p_p)VALUES(?,?,?,?)";
                        $stmt=$conn->prepare($sql);
                        $stmt->execute([$name,$username,$newPass,$imgName]);
                    }else{
                        $sql="INSERT INTO users(name,username,password)VALUES(?,?,?)";
                        $stmt=$conn->prepare($sql);
                        $stmt->execute([$name,$username,$newPass]);
                    }
                    $sm="Created Account";
                    header("location:../../index.php?Success=$sm");
                    exit();
                }else{
                    $em="Username is Retaken";
                    header("location:../../signupForm.php?error=$em&$data");
                    exit();
                }
            }
        }
    }
}else{
    header("location:../../signupForm.php");
    exit();
}