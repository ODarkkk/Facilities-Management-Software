<?php
include_once ("config.php");
// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit(); // Ensure script stops after redirect
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

</head>

<body>
<script>
$(document).ready(function() {
    $.ajax({
            url: 'installations_list.php',
            type: 'GET',
            // data: { value: selectedValue },
            success: function(response) {
                $("#installationslist").html(response);
                // Handle the response here
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Console.error();
                // Handle the error here
            }
        });
    $('.dropdown-item').click(function(e) {
        e.preventDefault();

        // Remove active class from all items
        $('.dropdown-item').removeClass('active');

        // Add active class to the clicked item
        $(this).addClass('active');

        // Get the value from the data-value attribute
        var selectedValue = $(this).data('value');

        // Send the AJAX request
        $.ajax({
            url: 'installations_list.php',
            type: 'GET',
            data: { value: selectedValue },
            success: function(response) {
                $("#installationslist").html(response);

                // Handle the response here
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Console.error();
                // Handle the error here
            }
        });
    });
    $("#installsearch").on("input",function(e) {
    e.preventDefault();
        var installsearch = $("#installsearch").val();
        $.ajax({
            url: 'installations_list.php',
            type: 'GET',
            data: { installsearch: installsearch },
            success: function(response) {
                $("#installationslist").html(response);
                // Handle the response here
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Console.error();
                // Handle the error here
            }
        });
    })
});
</script>
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
                <a class="nav-link" href="./installations.php">Installations</a>
                
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
    
    <h1>Installations</h1>
    <?php if($_SESSION['admin']){ ?>
    <button type="button" onclick="location.href = 'new_installations.php';" class="btn btn-success">New Installations</button> <?php } ?>
    

    <nav class="navbar">
    <form class="form-inline">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" id="installsearch">
        </div>
    </form>
</nav>
    <div class="row" id="installationslist">
    <!-- Room list will be dynamically inserted here -->
</div>

    <div class="fixed-bottom">
        <div class="btn-group dropup">
            <div class="button-change">
                <button type="button" class="beautiful-button dropdown-toggle" id="changeButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Change
                </button>
                <div>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item active">All</a></li>
                    <li><a class="dropdown-item" data-value="room">Room</a></li>
                    <li><a class="dropdown-item" data-value="office">Office</a></li>
                    <li><a class="dropdown-item" data-value="building">Building</a></li>
                    </ul>
                </div>
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
    <a class="Btn" onclick="goBack()">

      <div class="sign"><svg viewBox="0 0 512 512">
          <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
        </svg></div>

      <div class="text">Back</div>
    </a>
  </div>

    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
</body>

</html>