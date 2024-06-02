<?php
include_once 'config.php';
if (isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION['user_id2'])) {
    header("location: logout.php");
    exit;
}
$error_message = "";


// function encrypt_session_data($data, $secret_key)
// {
//     $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
//     $iv = openssl_random_pseudo_bytes($ivlen);
//     $ciphertext = openssl_encrypt($data, $cipher, $secret_key, $options = 0, $iv);
//     return base64_encode($iv . $ciphertext);
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirmation-password'];

    if ($new_password !== $confirm_password) {
        $error_message = "New password and confirmed password do not match.";
    }
    if (!securePassword($_new_password)) {
        $error_message = "Password must be at least 8 characters long and contain at least one";
    }
    if ((error($error_message)) == "") {
        $error_message = error($error_message);
        $new_password = password_hash($new_password, 
        PASSWORD_DEFAULT); 
        $sql = "UPDATE `people` SET `password` = '?', `password_status` = '0' WHERE `people`.`people_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $_SESSION['user_id2']);
        $stmt->execute();
        header("location: logout.php");
        exit;
    }

    
} 

?>

<!DOCTYPE html>
<html lang="en">
<!-- <html lang="en" data-bs-theme="dark"> -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="index.js" crossorigin="anonymous">    -->
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="script.js"></script>
    <noscript>
        <style type="text/css">
            .pagecontainer {
                display: none;
            }
        </style>
        <div class="noscriptmsg">
            You don't have javascript enabled. For this site to work, javascript is required. </div>
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
            <p><?php echo $_SESSION['user2']?></p>
        </h1>
    </div>

    <div class="container mt-5">
        <div class="container mt-5 d-flex justify-content-center">
            <form action="new_password.php" method="post">
                <div class="mb-3 mx-auto">
                    <label for="username" class="form-label">New Password</label>
                    <input type="password" class="form-control custom-input" name="new-password" id="new-password" required>
                </div>
                <div class="mb-3 mx-auto">
                    <label for="password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control custom-input" name="confirmation-password" id="confirmation-password" required>
                </div>
                <?php
                if (isset($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                }
                ?>
                <button type="submit" style="margin-left: 30%" class="btn btn-primary">Submit</button>

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
    <div class="position-relative">

        <div class="position-fixed top-0 end-0">
            <a class="Btn" href="logout.php">
                <div class="sign"><svg viewBox="0 0 512 512">
                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                    </svg></div>
                <div class="text">Back</div>
            </a>
        </div>

    </div>
</body>

</html>