<?php
include_once("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}
$edit = false;
$error_message = "";
$role = null;
$selected = null; //pre select the values 
if (isset($_GET['userId'])) {
    $edit = true;
    $id = $_GET['userId'];

    // Prepare query with parameterized query
    $stmt = $conn->prepare("SELECT p.people_id, p.user, p.name, rd.roles_department_id, d.department, r.role, p.photo, p.email, p.phone, p.admin, p.password_status, p.active 
    FROM people p 
    JOIN roles_department rd ON rd.roles_department_id = p.role_department_id 
    JOIN department d ON d.department_id = rd.department_id 
    JOIN roles r ON r.role_id = rd.role_id
    WHERE p.people_id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // $role = $row['role_department_id'];
    }
    // if ($result && $result->num_rows > 0) {
    // $row = $result->fetch_assoc();

    // while($row = $result->fetch_assoc()) {  

    //     }
    // } 
}

if (isset($_POST['submit'])) {
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-new-password'];

    if ($new_password !== $confirm_password) {
        $error_message = "New password and confirmed password do not match.";
    }

    if (!securePassword($new_password)) {
        //password is invalid
        $error_message = "Password must be at least 8 characters long and contain at least one";
    }
    if ((error($error_message)) == "") {
        $error_message = error($error_message);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<!-- <html lang="en" data-bs-theme="dark"> -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="index.js" crossorigin="anonymous">    -->
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script>



    <script type="importmap">
        {
		  "imports": {
			"@popperjs/core": "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/esm/popper.min.js",
			"bootstrap": "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.esm.min.js"
		  }
		}
		</script>

</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


    <p>

    <nav class="navbar navbar-light bg-light navbar-expand-lg navbar-light" style="transition: height 0.5s; margin:2%">
        <div class="container-fluid">
            <div class="col-md-1">
                <a href="index.php"><img src="images/esgc.png" class="rounded img-fluid img-small w-50" alt="company_logo"></a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column" id="navbarNav">
                <div class="navbar-nav ms-0 me-5  mt-auto"> <!-- Aplicando a classe me-auto para mover o session user para a margem esquerda -->
                    <a class="nav-link" href="./index.php">Home</a>
                    <a class="nav-link" href="./reserves.php">Reserves</a>
                    <a class="nav-link" href="./user.php">Users</a>
                    <a class="nav-link" href="./installations.php.php">installations</a>

                    <?php

                    if ($_SESSION['admin'] == 1) {
                    ?>
                        <a class="nav-link" href="./tickets.php">Recovers requests</a>
                        <a class="nav-link" href="./roles.php">Roles</a>
                    <?php
                    }
                    ?>
                </div>

                <div class="navbar-nav mb-auto ms-auto"> <!-- Mantendo os links à direita -->
                    <div class="nav-link">
                        <?php
                        echo $_SESSION['user'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    </p>

    <div class="container mt-5">
        <h2>New User</h2>
        <div class="container mt-5 d-flex justify-content-center">
            <form action="add_user.php?edit=<?php echo $edit ?>$" method="post">
                <!-- <h5>Admin Credentials</h5>
                <div class="col-md-6">
                    <label for="admin-username" class="form-label">Admin-User</label>
                    <input type="text" class="form-control custom-input" name="admin-user" id="admin-user" required>
                </div>
                <div class="mb-3 mx-auto">
                    <label for="admin-password" class="form-label">Admin-Password</label>
                    <input type="password" class="form-control custom-input" name="admin-password" id="admin-password" required>
                </div> -->

                <div class="col-md-6">
                    <!-- <h5>User Credentials</h5> -->



                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control custom-input" name="username" id="username" value="<?php if ($edit) {
                                                                                                                    echo $row['user'];
                                                                                                                } ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control custom-input" name="name" id="name" value="<?php if ($edit) {
                                                                                                            echo $row['name'];
                                                                                                        } ?> " required>
                </div>
                <?php
                if ($edit == false) {
                ?>
                    <div class="col-md-6">
                        <label for="date_birth" class="form-label">date of birth</label>
                        <input type="date" class="form-control custom-input" name="date" id="date" required>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-6">
                    <label for="name" class="form-label">Department:</label>
                    <select name="department" id="department">
                        <?php
                        if ($edit == false) {
                            echo '<option value="" selected >Select Department</option>';
                        }



                        $sql = "SELECT * FROM department";


                        $result = $conn->query($sql);

                        // Check if there are any departments
                        if ($result->num_rows > 0) {
                            // Output options for each department

                            while ($row2 = $result->fetch_assoc()) {
                                if ($edit && $row['rd.roles_department_id'] == $row2['department_id']) {
                                    echo "<option value='" . $row2['department_id'] . "' selected>" . $row2['department'] . "</option>";
                                } else {
                                    echo "<option value='" . $row2['department_id'] . "'>" . $row2['department'] . "</option>";
                                }
                            }
                        } else {
                            // Output a default option if no departments found
                            echo "<option value=''>No results found</option>";
                        }

                        ?>

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Role:</label>
                    <select name="role" id="role">


                    </select>
                </div>


                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control custom-input" name="email" id="email" value="<?php if ($edit) {
                                                                                                                echo $row['email'];
                                                                                                            } ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control custom-input" name="photo" id="photo" value="<?php if ($edit) {
                                                                                                            echo $row['photo'];
                                                                                                        } ?>" required>
                </div>
                <?php
                if ($edit == false) {
                ?>
                    <div class="col-md-6">
                        <label for="nationality" class="form-label">Nationality</label>
                        <input type="text" class="form-control custom-input" name="nationality" id="nationality" required>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-6">
                    <label for="phone" class="form-label">phone</label>
                    <input type="text" class="form-control custom-input" name="phone" id="phone" value="<?php if ($edit) {
                                                                                                            echo $row['name'];
                                                                                                        } ?>" required>
                </div>
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
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="admin" name="admin" value="<?php if ($edit) {
                                                                                                            echo $row['admin']; ?>" <?php if ($row['admin'] == 1) echo 'checked';
                                                                                                                                } ?>>
                        <label class="form-check-label" for="admin">
                            Admin
                        </label>
                    </div>
                    <?php
                    if ($edit == true) {
                        echo "<input type='hidden' id='peopleid' name='peopleid' value='" . $row['people_id'] . "' /> ";
                        echo "<input type='hidden' id='edit' name='edit' value='" . $edit . "' /> ";
                    }
                    if (isset($error_message)) {
                        echo "<p style='color: red;'>$error_message</p>";
                    }
                    ?>
                    <button type="submit" style="margin-left: 30%" class="btn btn-primary">Submit</button>


            </form>

        </div>

    </div>

    </div>
    <!-- <button  class="button-log"> <img src="images/exit.png" alt="exit" width="100%"></button>
	  </div> -->
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

    <!-- <button  class="button-log"> <img src="images/exit.png" alt="exit" width="100%"></button>
	  </div> -->
    <div class="position-relative">

        <div class="position-fixed top-0 end-0">
            <a class="Btn" onclick="goBack()">

                <div class="sign"><svg viewBox="0 0 512 512">
                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                    </svg></div>

                <div class="text">Back</div>
            </a>
        </div>
    </div>
</body>

</html>