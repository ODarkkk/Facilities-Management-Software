<?php
include_once('config.php');
// function decrypt_session_data($data, $cret_key)
// {
//     $data = base64_decode($data);
//     $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
//     $iv = substr($data, 0, $ivlen);
//     $ciphertext = substr($data, $ivlen);
//     $plaintext = openssl_decrypt($ciphertext, $cipher, $secret_key, $options = 0, $iv);
//     return $plaintext;
// }
// include_once('bd.php');
// session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
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
        .pagecontainer {display:none;}
    </style>
    <div class="noscriptmsg">
    You don't have javascript enabled. For this site to work, javascript is required.    </div>
</noscript>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        $(document).ready(function() {
        var selectedDate = document.getElementById("dateFilter").value;
        // var officeSelect = 1;

        // // Set the default selected date to today
        // var today = new Date();
        // var dateString = today.toISOString().split('T')[0];

        // // Convert the selectedDate to the format YYYY-MM-DD
        // selectedDate = selectedDate.toISOString().split('T')[0];
        var today = new Date();
        var dateString = today.toISOString().split('T')[0];
        document.getElementById("dateFilter").value = dateString;

        // Send the AJAX request with the selectedDate
        $.ajax({

            type: "GET",
            method: "GET",
            url: "mark_list.php",
            data: {
                dateFilter: selectedDate,
                    // officeSelect: officeSelect,
                    // roomSelect: roomSelect,
                    // buildingSelect: buildingSelect

                // officeSelect: officeSelect
            },
            success: function(response) {
                // Display the received HTML
                $("#markList").html(response);
                // Store the selected date in a JavaScript variable
                selectedDate = dateString;;
                // console.log(dateString)
            }

        });
        $("#dateFilter").change(function() {
            var selectedDate = $("#dateFilter").val();
            var officeSelect = $("#officeSelect").val();
            var roomSelect = $("#roomSelect").val();
            var buildingSelect = $("#buildingSelect").val();

            $.ajax({
                type: "GET",
                url: "mark_list.php",
                data: {
                    dateFilter: selectedDate,
                    officeSelect: officeSelect,
                    roomSelect: roomSelect,
                    buildingSelect: buildingSelect
                },
                success: function(response) {
                    // Display the received HTML
                    $("#markList").html(response);
                    // Store the selected date in a JavaScript variable
                    selectedDate = dateString;
                }
            });
        });
      
        // var today = new Date();
        // var dateString = today.toISOString().split('T')[0];
        // // selectedDate = selectedDate.toISOString().split('T')[0];
        // // Send the AJAX request with the selectedDate
        // fetchRoomList();

        // // Attach a change event listener to the date input element
        // $("#dateFilter").change(function() {
        //     fetchRoomList();
        // });

        });
    </script>
</head>

<body data-needs-fetchrooms="true">

    <?php

    // if (isset($_SESSION['admin'])) {
    // $decrypted_data = decrypt_session_data($_SESSION['admin'], $secret_key);

    // // Checking if decrypted value is true
    // if ($decrypted_data && $decrypted_data == 1) {
    //     // Setting admin session as true
    //     $_SESSION['admin'] = 1;
    //     // Your code for admin view

    ?>
    <!-- <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">Collapsed content</h4>
            <span class="text-muted">Toggleable via the navbar brand.</span>
        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        < <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</div> -->


    <?php
    // } else {
    //     // Set the admin session to false
    //     $_SESSION['admin'] = 0;
    // }
    if ($_SESSION['admin'] == 1) {
    ?>
        <!-- <br>
          <br> -->





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
                        <a class="nav-link" href="#">Tickets</a>
                        <a class="nav-link" href="#">Add new user</a>
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
    <?php
    }

    // }


    ?>
    <div class="content">


        <!-- <div class="text-center">
           <img src="images/esgc.png" class="rounded" alt="company">
        </div> -->

    </div>
    <div class="col-md-2">
        <?php
        //  echo $_SESSION['user'];
        ?>
       <label for="dateFilter" class="form-label">Date:</label>
<input type="date" class="form-control" id="dateFilter" name="dateFilter">
    </div>


    <!-- <div class="container mt-5">


    <h1 class="mb-3"></h1> -->

        <div class="row" id="markList">
            <!-- Room list will be dynamically inserted here -->
        </div>

        <!-- Additional content, buttons, or elements can be added here -->

    <!-- </div> -->

    <div class="fixed-bottom">
        <div class="button-change">
            <button class="beautiful-button" id="changeButton" data-bs-toggle="modal" data-bs-target="#officeModal">
                Change
            </button>
        </div>
    </div>

    <!-- Modal for the nice combobox -->
    <!-- <div class="modal fade" id="officeModal" tabindex="-1" aria-labelledby="officeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="officeModalLabel">Select an Office</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select" id="officeSelect">
                        <script>
                            fetch('fetch_offices.php')
                                .then(response => response.text())
                                .then(data => {
                                    
                                    // Assuming data is in the format "<option>...</option><option>...</option>"
                                    const selectElement = document.getElementById('officeSelect')
                
                                    selectElement.innerHTML = data;

                                })
                                .catch(error => {
                                    console.error("Error fetching data:", error);
                                });
                        </script>
                        Options will be dynamically inserted here -->
                    <!-- </select>
                </div>
                <div class="modal-footer">
                    <?php
                    // echo "<button type='button' class='btn btn-primary' id='selectOfficeButton'>Select</button>";
                    // echo "<button type='button' class='btn btn-primary' id='selectOfficeButton' onclick=\"location.href='room_list.php?room_id='\">Select</button>";
                    ?>
                </div>
            </div>
        </div>
    </div> --> 
    <!-- Modal for the nice combobox -->
<div class="modal fade" id="officeModal" tabindex="-1" aria-labelledby="officeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="officeModalLabel">Select an Office or Building</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="office-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="offices-tab" data-bs-toggle="tab" href="#offices" role="tab" aria-controls="offices" aria-selected="true">Offices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="buildings-tab" data-bs-toggle="tab" href="#buildings" role="tab" aria-controls="buildings" aria-selected="false">Buildings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="room-tab" data-bs-toggle="tab" href="#rooms" role="tab" aria-controls="rooms" aria-selected="false">Rooms</a>
                    </li>
                </ul>
                <div class="tab-content" id="office-tabs-content">
                    <div class="tab-pane fade show active" id="offices" role="tabpanel" aria-labelledby="offices-tab">
                        <select class="form-select" id="officeSelect">
                            <script>
                                fetch('fetch_offices.php')
                                   .then(response => response.text())
                                   .then(data => {
                                        const selectElement = document.getElementById('officeSelect')
                                        selectElement.innerHTML = data;
                                    })
                                   .catch(error => {
                                        console.error("Error fetching data:", error);
                                    });
                            </script>
                            <!-- Options will be dynamically inserted here -->
                        </select>
                    </div>
                    <div class="tab-pane fade" id="buildings" role="tabpanel" aria-labelledby="buildings-tab">
                        <select class="form-select" id="buildingSelect">
                            <script>
                                fetch('fetch_buildings.php')
                                   .then(response => response.text())
                                   .then(data => {
                                        const selectElement = document.getElementById('buildingSelect')
                                        selectElement.innerHTML = data;
                                    })
                                   .catch(error => {
                                        console.error("Error fetching data:", error);
                                    });
                            </script>
                            <!-- Options will be dynamically inserted here -->
                        </select>
                    </div>
                    <div class="tab-pane fade show active" id="rooms" role="tabpanel" aria-labelledby="rooms-tab">
                        <select class="form-select" id="roomSelect">
                            <script>
                                fetch('fetch_room.php')
                                   .then(response => response.text())
                                   .then(data => {
                                        const selectElement  = document.getElementById('roomsSelect')
                                        selectElement.innerHTML = data;
                                    })
                                   .catch(error => {
                                        console.error("Error fetching data:", error);
                                    });
                            </script>
                            <!-- Options will be dynamically inserted here -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo "<button type='button' class='btn btn-primary' id='Filter'>Select</button>";
               ?>
            </div>
        </div>
    </div>
</div>




    <!-- Modal for the nice combobox  -->
    <!-- <div class="modal fade" id="officeModal" tabindex="-1" aria-labelledby="officeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="officeModalLabel">Select an Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select" id="officeSelect">
                 Options will be dynamically inserted here -->
    <!-- </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="selectOfficeButton">Select</button>
            </div>
        </div>
    </div>
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

    <div class="position-relative">

    <div class="position-fixed top-0 end-0">
        <a class="Btn" href="logout.php">
            <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                </svg></div>
            <div class="text">Logout</div>
        </a>
    </div>

    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
</body>

</html>