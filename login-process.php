
<?php
session_start();
include_once('bd.php');
    //Verify if the credentials is correct~
    echo 'inicio';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
        echo 'post';
      $user = $_POST['user'];
      $password = $_POST['password'];
      // $decrypt = password_hash($password,  
      //     PASSWORD_DEFAULT); 

     
     $sql = "SELECT * FROM `people` WHERE user = '$user' AND password = '$password'";
 
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
      while ( $row = $result->fetch_assoc()){
        $_SESSION['user_id'] = $row["id"];
        $_SESSION['user'] = $row["name"];
        $_SESSION['email'] = $row ["email"] ;
        echo 'chegou aqui';
      }
      echo 'error credentials';
      header("location: index.php");

    }
    else {
    header("location: login.php");
  echo "<p style='color: red;'>Credential incorrect! Try again.</p>";
    }
}

    