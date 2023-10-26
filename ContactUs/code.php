
<?php
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

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

            $insertquery = "INSERT INTO `contactus` (`email`, `full_name`, `msg`, `dt`)
                VALUES (:email, :name, :desc, current_timestamp())";

            $stmt = $con->prepare($insertquery);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":desc", $desc);
            $result=$stmt->execute();
            $mail=new PHPMailer();

                $mail->isSMTP();                                      
                $mail->Host = ' smtp.gmail.com';  
                $mail->SMTPAuth = true;                               
                $mail->Username = 'tilu9454@gmail.com';                 
                $mail->Password = 'glcgothqdxbvqelp';                    
                $mail->SMTPSecure = 'ssl';                            
                $mail->Port = 465; 
                $mail->isHTML(true);
                $mail->setFrom('tilu9454@gmail.com', 'Divyansh verma');
                $mail->addReplyTo('tilu9454@gmail.com', 'Divyansh verma');

                $mail->addAddress($email,$name);
                $mail->addAddress('tilu9454@gmail.com', 'Divyansh verma');
                $mail->addAttachment($_FILES['image']['tmp_name'],$_FILES['image']['name']);
                $mail->Subject = "Query form the contactus page";
                $mail->Body    = $desc;

                if(!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: '. $mail->ErrorInfo;
                }
            move_uploaded_file($file_tmp, "images/" . $file_name);

            if($result){
                $_SESSION['success message']="Added successfully";
                header("Location: index.php");
                exit(0);
            }
            else{
                $_SESSION['error message']="Something went wrong";
                header("Location: index.php");
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
