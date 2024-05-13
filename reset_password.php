<?php
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // $adminUser = $_POST["admin-user"];
    // $adminPassword = $_POST["admin-password"];
    $newPassword = $_POST["new-password"];
    $confirmNewPassword = $_POST["confirm-new-password"];
    $logon = isset($_POST["logon"]) ? 1 : 0;

    // $sql = "SELECT * FROM `people` WHERE user = '$adminUser' AND password = '$adminPassword'";

    // Execute the query
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
        require_once('verify_password.php');
        if ($newPassword != $confirmNewPassword) {
            $error_message = "New Password doesn't match! Try again.";
        } else {
            if (securePassword($newPassword) == true) {
                $encryptPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user = mysqli_real_escape_string($conn, $_GET['user']);

                // Create the SQL query using prepared statements
                $sql = "UPDATE `people` SET `password` = ? WHERE `user` = ?";

                // Prepare the statement
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("ss", $encryptPassword, $user);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "Password updated successfully.";
                    } else {
                        echo "Error updating password: " . $conn->error;
                    }
                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }
            }
        }
    // } else {
    //     $error_message = "Credential incorrect! Try again.";
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Recover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <br><br><br><br><br><br>
    <div class="d-flex justify-content-center">
        <h1>Password Recover</h1>
    </div>
    <div class="d-flex justify-content-center">
        <h2>User: <?php echo $_GET['user'] ?></h2>
    </div>

    <div class="container mt-5">
        <div class="container mt-5 d-flex justify-content-center">
            <form action="reset_password.php" method="post">
                <!-- <div class="col-md-6">
                    <label for="admin-username" class="form-label">Admin-User</label>
                    <input type="text" class="form-control custom-input" name="admin-user" id="admin-user" required>
                </div>
                <div class="mb-3 mx-auto">
                    <label for="admin-password" class="form-label">Admin-Password</label>
                    <input type="password" class="form-control custom-input" name="admin-password" id="admin-password" required>
                </div> -->
                <div class="col-md-6">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="password" class="form-control custom-input" name="new-password" id="new-password" required>
                </div>
                <div class="mb-3 mx-auto">
                    <label for="confirm-new-password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control custom-input" name="confirm-new-password" id="confirm-new-password" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="logon" name="logon">
                        <label class="form-check-label" for="logon">
                            User must change password at next logon
                        </label>
                    </div>
                    <?php
                    if (isset($error_message)) {
                        echo "<p style='color: red;'>$error_message</p>";
                    }
                    ?>
                    <button type="submit" style="margin-left: 30%" class="btn btn-primary">Submit</button>


            </form>

        </div>

    </div>
    </div>

</body>

</html>
