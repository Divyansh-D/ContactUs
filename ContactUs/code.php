<?php
include('dbcon.php');

session_start();
if (isset($_POST['btns'])) {
    $name = $_POST['uname'];
    $email = $_POST['email'];
    $desc = $_POST['desc'];
    if (empty($_FILES['image']['name'])) {
        $_SESSION['error message']="Please upload the file.";
        header("Location: index.php");
        exit(0);
    }
    else if(empty($name) || strlen((trim($name))<3)){
        $_SESSION['error message']="Enter valid name.";
        header("Location: index.php");
        exit(0);
    }
    else if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error message']="Enter valid email.";
        header("Location: index.php");
        exit(0);
    }
    else if (empty($desc)) {
        $_SESSION['error message']="Enter valid discrption.";
        header("Location: index.php");
        exit(0);
    }
    else{
        try {
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
        
            move_uploaded_file($file_tmp, "images/" . $file_name);

            $insertquery = "INSERT INTO `contactus` (`email`, `full_name`, `msg`, `dt`)
                VALUES (:email, :name, :desc, current_timestamp())";

            $stmt = $con->prepare($insertquery);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":desc", $desc);
            $result=$stmt->execute();

            if($result){
                $_SESSION['message']="Added successfully";
                header("Location: index.php");
                exit(0);
            }
            else{
                $_SESSION['message']="Something went wrong";
                header("Location: index.html");
                exit(0);
            }
            
        } catch (PDOException $e) {
            echo "Error!" .$e->getMessage();
        } finally {
            $con = null;
        }
    }
}

?>
