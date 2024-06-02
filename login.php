<?php
include_once 'config.php' ;
if(isset($_SESSION['user_id']))
{
 header("location: index.php");
 exit;
}

// function encrypt_session_data($data, $secret_key)
// {
//     $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
//     $iv = openssl_random_pseudo_bytes($ivlen);
//     $ciphertext = openssl_encrypt($data, $cipher, $secret_key, $options = 0, $iv);
//     return base64_encode($iv . $ciphertext);
// }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $user = $_POST['user'];
    $password = $_POST['password'];
   
    $sql = "SELECT * FROM `people` WHERE user = '$user' AND active=1";
  
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
        if($row['password_status'] == 1){
          $_SESSION['user_id2'] = $row["people_id"];
          $_SESSION['user2'] = $row["name"];
          echo "<script>window.location.href = 'new_password.php';</script>";
          exit;
        }
        $_SESSION['user_id'] = $row["people_id"];
        $_SESSION['user'] = $row["name"];
        $_SESSION['email'] = $row["email"];
        $_SESSION['admin'] = $row["admin"];
      echo "<script>window.location.href = 'index.php';</script>";
      exit;
    }  else
    {
      $error_message = "Credential incorrect! Try again.";
    }
    }
    } else {

      // echo "<p style='color: red;'>Credential incorrect! Try again.</p>";
      $error_message = "Credential incorrect! Try again.";

    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<!-- <html lang="en" data-bs-theme="dark"> -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="index.js" crossorigin="anonymous">    -->
  <link rel="stylesheet" href="styles.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <script src="script.js"></script>
  <noscript>
    <style type="text/css">
        .pagecontainer {display:none;}
    </style>
    <div class="noscriptmsg">
    You don't have javascript enabled. For this site to work, javascript is required.    </div>
</noscript>
  <!-- <script type="importmap">
    {
		  "imports": {
			"@popperjs/core": "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/esm/popper.min.js",
			"bootstrap": "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.esm.min.js"
		  }
		}
		</script> -->

</head>


<script type="module">
  // import {
  //   Toast
  // } from 'bootstrap.esm.min.js'

  Array.from(document.querySelectorAll('.toast'))
    .forEach(toastNode => new Toast(toastNode))
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<body>
  <br>
  <br> <br> <br> <br> <br>
  <div class="d-flex justify-content-center">
    <h1>
      <p>Login</p>
    </h1>
  </div>

  <div class="container mt-5">
    <div class="container mt-5 d-flex justify-content-center">
      <form action="login.php" method="post">
        <div class="mb-3 mx-auto">
          <label for="username" class="form-label">User</label>
          <input type="text" class="form-control custom-input" name="user" id="user" required>
        </div>
        <div class="mb-3 mx-auto">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control custom-input" name="password" id="password" required>
        </div>
        <?php
        if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
        <button type="submit" style="margin-left: 30%" class="btn btn-primary">Submit</button>
        <div class="text-left mt-5">
          <span><a a href="recover.php">I forgot my password</a></span>
        </div>
    </div>
    </form>

  </div>

  </div>
  </div>
  <div class="position-fixed bottom-0 end-0">
    <label class="switch">
      <span class="sun"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <g fill="#ffd43b">
            <circle r="5" cy="12" cx="12"></circle>
            <path d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z"></path>
          </g>
        </svg></span>
      <span class="moon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
          <path d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path>
        </svg></span>
      <input type="checkbox" class="input" id="toggleButton" onclick="toggleMode()">
      <span class="slider"></span>
    </label>
  </div>
  
</body>

</html>