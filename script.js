// $(document).ready(function() {
//   // Event listener for the "Select" button in the modal
//   $("#selectOfficeButton").click(function() {
//       // Get the selected value from the combobox
//       var selectedOffice = $("#officeSelect").val();

//       // Here you can do what you need with the selected office,
//       // such as sending another AJAX request to fetch specific data of the selected office and updating the page, etc.

//       // For now, we'll just display the selected value in the console
//       console.log("Selected Office: " + selectedOffice);

//       // Close the modal
//       $("#officeModal").modal("hide");
//   });

//   // Function to fetch offices and display the dropdown
//   const fetchOffices = async () => {
//       try {
//           const response = await fetch('fetch_offices.php');
//           const data = await response.text();
//           const officeDropdown = document.getElementById('officeDropdown');
//           officeDropdown.innerHTML = data;
//           officeDropdown.addEventListener('change', (event) => {
//               const selectedOfficeId = event.target.value;
//               console.log(`Selected office ID: ${selectedOfficeId}`);
//               // Add functionality for handling the selected office
//           });
//       } catch (error) {
//           console.error('Error fetching office dropdown:', error);
//       }
//   };

//   // Function to show the office selection menu
//   const showOfficeSelection = () => {
//       const officeSelection = document.getElementById('officeSelection');
//       officeSelection.classList.toggle('d-none');
//   };

//   // Check if the user clicks outside of the office selection menu
//   const handleClickOutside = (event) => {
//       if (!event.target.closest('.office-selection')) {
//           showOfficeSelection();
//       }
//   };

//   // Attach event listeners
//   document.getElementById('toggleButton').addEventListener('click', showOfficeSelection);
//   document.addEventListener('click', handleClickOutside);
//   fetchOffices();

//   // Now add event listener for the select button
//   $("#selectOfficeButton").click(function() {
//       // Get the selected office
//       const officeSelectElement = document.getElementById('officeSelect');
//       const selectedOfficeIndex = officeSelectElement.selectedIndex;
//       const selectedOffice = officeSelectElement.options[selectedOfficeIndex].value;

//       // Do something with the selected office
//       console.log(`Selected office: ${selectedOffice}`);
//   });
// });

function goBack() {
  window.history.back();
}

function toggleMode() {
  const body = document.body;
  const button = document.getElementById("toggleButton");

  if (body.classList.contains("dark-mode")) {
    // Muda para o Light Mode
    body.classList.remove("dark-mode");
    body.classList.add("light-mode");
    button.innerHTML = "Dark Mode";
  } else {
    // Muda para o Dark Mode
    body.classList.remove("light-mode");
    body.classList.add("dark-mode");
    button.innerHTML = "Light Mode";
  }
}

// function updateSelectedBuildingOffice() {
//     const selectedBuilding = $("#buildingSelect option:selected").text();
//     const selectedOffice = $("#officeSelect option:selected").text();
//     $("#selectedBuildingOffice").text(`Building: ${selectedBuilding}, Office: ${selectedOffice}`);
// }

// // Call the function on page load
// $(document).ready(function() {
//     updateSelectedBuildingOffice();
// });

// // Call the function when there's a change in the office selection
// $("#officeSelect").change(function() {
//     updateSelectedBuildingOffice();
// });

$(document).ready(function () {
  $("#selectOfficeButton").click(function () {
    const selectedOffice = $("#officeSelect").val();
    const date = $("#dateFilter").val();
    const search = $("#search").val();

    // const officeSelectElement = document.getElementById('officeSelect');
    // const selectedOfficeIndex = officeSelectElement.selectedIndex;
    // const selectedOfficeId = officeSelectElement.options[selectedOfficeIndex].value;

    // Enviar o ID do escritório para room_list.php usando AJAX
    // $.ajax({
    //   url: 'room_list.php',
    //   type: 'POST',
    //   data:{
    //     dateFilter: date,

    //   },
    // success: function(response) {
    //   $("#roomList").html(response);

    // Lidar com a resposta, se necessário
    // window.alert("certo");
    // console.log("Valor enviado com sucesso para room_list.php");

    // error: function(xhr, status, error) {
    //   console.error("Error fetching room list:", error);

    // Lidar com erros, se houver
    // window.alert("Errado");
    // console.error("Erro ao enviar valor para room_list.php:", error);

    // })

    $.ajax({
      url: "room_list.php",
      type: "GET",
      // type: 'GET',
      data: {
        dateFilter: date,
        officeSelect: selectedOffice,
        search: search,
      },
      success: function (response) {
        $("#roomList").html(response);

        // Lidar com a resposta, se necessário
        // window.alert("certo");
        // console.log("Valor enviado com sucesso para room_list.php");
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);

        // Lidar com erros, se houver
        // window.alert("Errado");
        // console.error("Erro ao enviar valor para room_list.php:", error);
      },
    });
      // Fechar o modal
      $("#officeModal").modal("hide");
  });
  $("#search").change(function () {
    const selectedOffice = $("#officeSelect").val();
    const date = $("#dateFilter").val();
    const search = $("#search").val();
    $.ajax({
      url: "room_list.php",
      type: "GET",
      // type: 'GET',
      data: {
        dateFilter: date,
        officeSelect: selectedOffice,
        search: search,
      },
      success: function (response) {
        $("#roomList").html(response);

        // Lidar com a resposta, se necessário
        // window.alert("certo");
        // console.log("Valor enviado com sucesso para room_list.php");
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);
      },
    });
    // Fechar o modal
    $("#officeModal").modal("hide");
  });

  // Function to fetch offices and display the dropdown
  // const fetchOffices = async () => {
  //   try {
  //     const response = await fetch('fetch_offices.php');
  //     const data = await response.text();
  //     const officeDropdown = document.getElementById('officeSelect');
  //     officeDropdown.innerHTML = data;
  //     officeDropdown.addEventListener('change', (event) => {
  //       const selectedOfficeId = event.target.value;
  //       console.log(`Selected office ID: ${selectedOfficeId}`);
  //     });
  //   } catch (error) {
  //     console.error('Error fetching office dropdown:', error);
  //   }
  // };

  // // Call the function to fetch offices and display the dropdown
  // const needsFetchOffices = document.body.dataset.needsFetchOffices === 'true';

  // if (needsFetchOffices) {
  //   fetchOffices();
  // }

  // const fetch = async () =>{
  //   try{
  //     const response = await fetch('fetch_offices.php');
  //     const response2 = await fetch('fetch_buildings.php');
  //     const data = await response.text();
  //     const data2 = await response2.text();
  //     const officeDropdown = document.getElementById('officeSelect');
  //     officeDropdown.innerHTML = data;
  //     const buildingDropdown = document.getElementById('buildingSelect');
  //     buildingDropdown.innerHTML = data2;

  //     officeDropdown.addEventListener('change', (event) => {
  //       const selectedOfficeId = event.target.value;
  //       console.log(selectedOfficeId);
  //     });
  //     buildingDropdown.addEventListener('change', (event) => {
  //       const selectedBuildingId = event.target.value;
  //       fetch(`fetch_offices.php?buildingId=${selectedBuildingId}`)
  //             .then(response => response.text())
  //             .then(data => {
  //                   const officeSelect = document.getElementById('officeSelect');
  //                   officeSelect.innerHTML = data;
  //               })
  //       console.log(selectedBuildingId);
  //     });

  //   }catch (error)
  //   {
  //    console.error('Error fetching dropdown:', error);
  //   }
  //   };
  //    // Call the function to fetch offices and display the dropdown
  //   const needsFetch = document.body.dataset.needsFetch === 'true';

  //   if(needsFetch){
  //     fetch();
  //   }

  // const buildingSelect = document.getElementById('buildingSelect');
  // const buildingDescriptionElement = document.getElementById('building-description');

  // buildingSelect.addEventListener('change', (event) => {
  //     const selectedBuildingId = event.target.value;
  //     const selectedOption = buildingSelect.options[buildingSelect.selectedIndex];
  //     const buildingDescription = selectedOption.getAttribute('data-description');
  //     buildingDescriptionElement.innerText = buildingDescription;

  //     fetch(`fetch_offices.php?buildingId=${selectedBuildingId}`)
  //       .then(response => response.text())
  //       .then(data => {
  //             const officeSelect = document.getElementById('officeSelect');
  //             officeSelect.innerHTML = data;
  //         })
  //       .catch(error => {
  //             console.error("Error fetching office data:", error);
  //         });
  // });

  const fetchOffices = async () => {
    try {
      const response = await fetch("fetch_offices.php");
      const data = await response.text();
      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching offices:", e.message);
    }
  };

  const fetchBuildings = async () => {
    try {
      const response = await fetch("fetch_buildings.php");
      const data = await response.text();
      const buildingDropdown = document.getElementById("buildingSelect");
      buildingDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching buildings:", e.message);
    }
  };

  const fetchOfficesForBuilding = async (buildingId) => {
    try {
      const response = await fetch(
        `fetch_offices.php?selectedBuildingId=${encodeURIComponent(buildingId)}`
      );
      const data = await response.text();
      const officeSelect = document.getElementById("officeSelect");
      officeSelect.innerHTML = data;
    } catch (e) {
      console.error("Error fetching offices for building:", e.message);
    }
  };

  const initDropdowns = async () => {
    try {
      await fetchOffices();
      await fetchBuildings();

      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.addEventListener("change", (event) => {
        const selectedOfficeId = event.target.value;
        console.log(selectedOfficeId);
      });

      const buildingDropdown = document.getElementById("buildingSelect");
      buildingDropdown.addEventListener("change", async (event) => {
        const selectedBuildingId = event.target.value;
        try {
          await fetchOfficesForBuilding(selectedBuildingId);
        } catch (e) {
          console.error("Error fetching offices for building:", e.message);
        }
        console.log(selectedBuildingId);
      });
    } catch (e) {
      console.trace("Message");
      console.error("Error fetching dropdown:", e.message);
    }
  };

  // Call the function to fetch offices and display the dropdown
  const needsFetch = document.body.dataset.needsFetch === "true";

  if (needsFetch) {
    initDropdowns();
  }
});

//For marks
$(document).ready(function () {
  // const filter = $("#filter").val();
  const date = $("#dateFilter").val();
  // const search = $("#marksearch").val();
  // $("#Filter").click(function () {
    // const selectedOffice = $("#officeSelect").val();
    // // dateFilter: selectedDate,
    // //                 officeSelect: officeSelect,
    // //                 roomSelect: roomSelect,
    // //                 buildingSelect: buildingSelect
    // const selectedroom = $("#roomSelect").val();
    // const buildingSelect = $("#buildingSelect").val();
    const sendAjaxRequest = (data) => {
    $.ajax({
      type: "GET",
      url: "mark_list.php",
      data: data,
      success: function(response) {
        $("#markList").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);

        // Lidar com erros, se houver
        // window.alert("Errado");
        // console.error("Erro ao enviar valor para room_list.php:", error);
      },
    });
  };
  $("#dateFilter, #marksearch, #filter").change(function() {
    const selectedDate = $("#dateFilter").val();
    const filter = $("#filter").val();
    const search = $("#marksearch").val();
    sendAjaxRequest({
      dateFilter: selectedDate,
      Filter: filter,
      search: search
    });
  });
  $("#Filter").click(function() {
    const date = $("#dateFilter").val();
    const filter = $("#filter").val();
    const search = $("#marksearch").val();
    const officeSelect = $("#officeSelect").val();
    const buildingSelect = $("#buildingSelect").val();
    const roomSelect = $("#roomSelect").val();

    let type;
    if (filter === 'room') {
      type = {
        type: filter,
        value: roomSelect
      };
    } else if (filter === 'office') {
      type = {
        type: filter,
        value: officeSelect
      };
    } else if (filter === 'building') {
      type = {
        type: filter,
        value: buildingSelect
      };
    } else {
      type = '';
    }
    sendAjaxRequest({
      dateFilter: date,
      Filter: filter,
      search: search,
      type: type,
      officeSelect: officeSelect,
      buildingSelect: buildingSelect,
      roomSelect: roomSelect
    });

    // Fechar o modal
    $("#SelectModal").modal("hide");
  });

  // Call the function to fetch rooms
  const needsFetchRooms = document.body.dataset.needsFetchRooms === "true";
  const fetchOffices = async () => {
    try {
      const response = await fetch("fetch_offices.php");
      const data = await response.text();
      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching offices:", e.message);
    }
  };

  const fetchBuildings = async () => {
    try {
      const response = await fetch("fetch_buildings.php");
      const data = await response.text();
      const buildingDropdown = document.getElementById("buildingSelect2");
      buildingDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching buildings:", e.message);
    }
  };
  const fetchrooms = async () => {
    try {
      const response = await fetch("fetch_room.php");
      const data = await response.text();
      const roomDropdown = document.getElementById("roomSelect2");
      roomDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching rooms:", e.message);
    }
  };

  const fetchOfficesForBuilding = async (buildingId) => {
    try {
      const response = await fetch(
        `fetch_offices.php?selectedBuildingId=${encodeURIComponent(buildingId)}`
      );
      const data = await response.text();
      const officeSelect = document.getElementById("officeSelect2");
      officeSelect.innerHTML = data;
    } catch (e) {
      console.error("Error fetching offices for building:", e.message);
    }
  };
  const fetchroomsforoffices = async (officeID) => {
    try {
      const responde = await fetch(
        `fecth_room.php?officeId=${encodeURIComponent(officeID)}`
      );
      const data = await responde.text();
      const roomSelect = document.getElementById("roomSelect2");
      roomSelect.innerHTML = data;
    } catch (e) {
      console.error("Error fetching rooms for office:", e.message);
    }
  };

  const initDropdowns = async () => {
    try {
      await fetchOffices();
      await fetchBuildings();
      await fetchrooms();

      const officeDropdown = document.getElementById("officeSelect2");
      officeDropdown.addEventListener("change", (event) => {
        const selectedOfficeId = event.target.value;
        console.log(selectedOfficeId);
      });

      const buildingDropdown = document.getElementById("buildingSelect2");
      buildingDropdown.addEventListener("change", async (event) => {
        const selectedBuildingId = event.target.value;
        try {
          await fetchOfficesForBuilding(selectedBuildingId);
        } catch (e) {
          console.error("Error fetching offices for building:", e.message);
        }
        console.log(selectedBuildingId);
      });

      const roomDropdown = document.getElementById("roomSelect2");
      roomDropdown.addEventListener("change", async (event) => {
        const selectedRoomId = event.target.value;
        try {
          await fetchroomsforoffices(selectedRoomId);
        } catch (e) {
          console.error("Error fetching rooms for office:", e.message);
        }
        console.log(selectedRoomId);
      });
    } catch (e) {
      console.trace("Message");
      console.error("Error fetching dropdown:", e.message);
    }
  };

  // Call the function to fetch offices and display the dropdown

  if (needsFetchRooms) {
    initDropdowns();
  }
})

$(document).ready(function() {
  var department_id = $('#department').val();
  updateRoles(department_id);

  $('#department').change(function() {
      var department_id = $(this).val();
      updateRoles(department_id);
  });
});

function updateRoles(departmentId) {
  $.ajax({
      url: "get_roles.php",
      method: "GET",
      data: {
          department_id: departmentId
      },
      success: function(response) {
          $("#role").html(response);
      },
      error: function(response) {
          console.error(response);
      }
  });
}
