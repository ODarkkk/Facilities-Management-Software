<?php
include_once('config.php');
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
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


</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <nav class="navbar navbar-light bg-light navbar-expand-lg navbar-light" style="transition: height 0.5s;">
        <div class="container-fluid">
            <div class="col-md-1">
                <img src="images/esgc.png" class="rounded img-fluid img-small w-50" alt="company_logo">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column" id="navbarNav">
                <div class="navbar-nav ms-0 me-5  mt-auto"> <!-- Aplicando a classe me-auto para mover o session user para a margem esquerda -->
                    <a class="nav-link" href="#">Home</a>
                    <a class="nav-link" href="#">About</a>
                    <a class="nav-link" href="#">Contact</a>
                </div>

                <div class="navbar-nav mb-auto ms-auto"> <!-- Mantendo os links à direita -->
                    <?php
                    echo $_SESSION['user'];
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
    <h1 class="text-center">New Department or Role</h1>
    <form action="/insert_data.php" method="post">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">New Department</h2>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department">
                </div>
                <button type="submit" name="action" value="create_department" class="btn btn-primary">New Department</button>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">New Role</h2>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" class="form-control" id="role" name="role">
                </div>
                <button type="submit" name="action" value="create_role" class="btn btn-primary">New Role</button>
            </div>
        </div>
    </form>
</div>
    <div class="container mt-5">
        <h1 class="text-center">Assign Role to Department</h1>
        <form action="/assign_role.php" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3"> <label for="department_id" class="form-label">Department</label> <select class="form-select" id="department_id" name="department_id" required>
                           <?php
                            $sql = "SELECT * from department";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='". $row['department_id']. "'>". $row['department']. "</option>";
                            }
                           ?>
                        </select> </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3"> <label for="role_id" class="form-label">Role</label> <select class="form-select" id="role_id" name="role_id" required>
                              <?php
                           $sql = "SELECT * from roles";
                           $result = mysqli_query($conn, $sql);
                           while ($row = mysqli_fetch_array($result)) {
                               echo "<option value='". $row['role_id']. "'>". $row['role']. "</option>";
                           }
                           ?>
                        </select> </div>
                </div>
                <div class="col-md-4"> <button type="submit" class="btn btn-primary">Assign</button> </div>
            </div>
        </form>
    </div>