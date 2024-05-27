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
        <div class="container mt-5 me-5">
            <h1 class="text-center">Assign Role to Department</h1>
            <form action="/assign_role.php" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3"> <label for="department_id" class="form-label">Department</label> <select class="form-select" id="department_id" name="department_id" required>
                                <?php
                                $sql = "SELECT * from department";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['department_id'] . "'>" . $row['department'] . "</option>";
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
                                    echo "<option value='" . $row['role_id'] . "'>" . $row['role'] . "</option>";
                                }
                                ?>
                            </select> </div>
                    </div>
                    <div class="col-mb-0"> <button type="submit" class="btn btn-primary">Assign</button> </div>
                </div>
            </form>
        </div>
    </div>
    <div style="position:fixed" ; class="position-absolute bottom-0 end-0">
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
    <div div class="position-absolute top-0 end-0">
        <a class="Btn" onclick="goBack()">

            <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                </svg></div>

            <div class="text">Back</div>
        </a>

    </div>
    <!-- <div class="fixed-bottom" >
    <button class="button-change"><img src="images/change_black.png" alt="change"></button>
  </div> -->

</body>

</html>