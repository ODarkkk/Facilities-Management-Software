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

// $(document).ready(function () {
//   $("#selectOfficeButton").click(function () {
//     const selectedOffice = $("#officeSelect").val();
//     const date = $("#dateFilter").val();
//     const search = $("#search").val();

//     $.ajax({
//       url: "room_list.php",
//       type: "GET",
//       // type: 'GET',
//       data: {
//         dateFilter: date,
//         officeSelect: selectedOffice,
//         search: search,
//       },
//       success: function (response) {
//         $("#roomList").html(response);

//         // Lidar com a resposta, se necessário
//         // window.alert("certo");
//         // console.log("Valor enviado com sucesso para room_list.php");
//       },
//       error: function (xhr, status, error) {
//         console.error("Error fetching room list:", error);

//         // Lidar com erros, se houver
//         // window.alert("Errado");
//         // console.error("Erro ao enviar valor para room_list.php:", error);
//       },
//     });
//       // Fechar o modal
//       $("#officeModal").modal("hide");
//   });
//   $("#search").on("input",function () {
//     const selectedOffice = $("#officeSelect").val();
//     const date = $("#dateFilter").val();
//     const search = $("#search").val();
//     $.ajax({
//       url: "room_list.php",
//       type: "GET",
//       // type: 'GET',
//       data: {
//         dateFilter: date,
//         officeSelect: selectedOffice,
//         search: search,
//       },
//       success: function (response) {
//         $("#roomList").html(response);

//         // Lidar com a resposta, se necessário
//         // window.alert("certo");
//         // console.log("Valor enviado com sucesso para room_list.php");
//       },
//       error: function (xhr, status, error) {
//         console.error("Error fetching room list:", error);
//       },
//     });
//     // Fechar o modal
//     $("#officeModal").modal("hide");
//   });

//   const fetchOffices = async () => {
//     try {
//       const response = await fetch("fetch_offices.php");
//       const data = await response.text();
//       const officeDropdown = document.getElementById("officeSelect");
//       officeDropdown.innerHTML = data;
//     } catch (e) {
//       console.error("Error fetching offices:", e.message);
//     }
//   };

//   const fetchBuildings = async () => {
//     try {
//       const response = await fetch("fetch_buildings.php");
//       const data = await response.text();
//       const buildingDropdown = document.getElementById("buildingSelect");
//       buildingDropdown.innerHTML = data;
//     } catch (e) {
//       console.error("Error fetching buildings:", e.message);
//     }
//   };

//   const fetchOfficesForBuilding = async (buildingId) => {
//     try {
//       const response = await fetch(
//         `fetch_offices.php?selectedBuildingId=${encodeURIComponent(buildingId)}`
//       );
//       const data = await response.text();
//       const officeSelect = document.getElementById("officeSelect");
//       officeSelect.innerHTML = data;
//     } catch (e) {
//       console.error("Error fetching offices for building:", e.message);
//     }
//   };

//   const initDropdowns = async () => {
//     try {
//       await fetchOffices();
//       await fetchBuildings();

//       const officeDropdown = document.getElementById("officeSelect");
//       officeDropdown.addEventListener("change", (event) => {
//         const selectedOfficeId = event.target.value;
//         console.log(selectedOfficeId);
//       });

//       const buildingDropdown = document.getElementById("buildingSelect");
//       buildingDropdown.addEventListener("change", async (event) => {
//         const selectedBuildingId = event.target.value;
//         try {
//           await fetchOfficesForBuilding(selectedBuildingId);
//         } catch (e) {
//           console.error("Error fetching offices for building:", e.message);
//         }
//         console.log(selectedBuildingId);
//       });
//     } catch (e) {
//       console.trace("Message");
//       console.error("Error fetching dropdown:", e.message);
//     }
//   };

//   // Call the function to fetch offices and display the dropdown
//   const needsFetch = document.body.dataset.needsFetch === "true";

//   if (needsFetch) {
//     initDropdowns();
//   }
// });
$(document).ready(function () {
  $("#selectOfficeButton").click(function () {
    const selectedOffice = $("#officeSelect").val();
    const date = $("#dateFilter").val();
    const search = $("#search").val();

    $.ajax({
      url: "room_list.php",
      type: "GET",
      data: {
        dateFilter: date,
        officeSelect: selectedOffice,
        search: search,
      },
      success: function (response) {
        $("#roomList").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);
      },
    });
    $("#officeModal").modal("hide");
  });

  $("#search").on("input", function () {
    const selectedOffice = $("#officeSelect").val();
    const date = $("#dateFilter").val();
    const search = $("#search").val();
    $.ajax({
      url: "room_list.php",
      type: "GET",
      data: {
        dateFilter: date,
        officeSelect: selectedOffice,
        search: search,
      },
      success: function (response) {
        $("#roomList").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);
      },
    });
    $("#officeModal").modal("hide");
  });

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

  const fetchOfficeDetails = async (officeId, buildingId) => {
    try {
      const response = await fetch(
        `office_details.php?officeId=${encodeURIComponent(officeId)}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details:", e.message);
    }
  };

  const initDropdowns = async () => {
    try {
      await fetchOffices();
      await fetchBuildings();

      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.addEventListener("change", (event) => {
        const selectedOfficeId = event.target.value;
        fetchOfficeDetails(selectedOfficeId);
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
      officeDropdown.addEventListener("change", (event) => {
        const selectedOfficeId = event.target.value;
        fetchOfficeDetails(selectedOfficeId);
        // Para atualizar o conteúdo do officeContent
        document.getElementById("officeContent").innerHTML = "";
      });
    } catch (e) {
      console.trace("Message");
      console.error("Error fetching dropdown:", e.message);
    }
  };

  const needsFetch = document.body.dataset.needsFetch === "true";
  if (needsFetch) {
    initDropdowns();
  }
});

//For marks
$(document).ready(function () {
  const date = $("#dateFilter").val();

  const sendAjaxRequest = (data) => {
    $.ajax({
      type: "GET",
      url: "mark_list.php",
      data: data,
      date,
      success: function (response) {
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
  $("#dateFilter, #marksearch, #filter").on("input", function () {
    const selectedDate = $("#dateFilter").val();
    const filter = $("#filter").val();
    const search = $("#marksearch").val();
    sendAjaxRequest({
      dateFilter: selectedDate,
      Filter: filter,
      search: search,
    });
  });
  $("#Filter").click(function () {
    const date = $("#dateFilter").val();
    const filter = $("#filter").val();
    const search = $("#marksearch").val();
    const officeSelect = $("#officeSelect").val();
    const buildingSelect = $("#buildingSelect").val();
    const roomSelect = $("#roomSelect").val();

    let type;

    switch (filter) {
      case "room":
        type = {
          type: filter,
          value: roomSelect,
        };
        break;
      case "office":
        type = {
          type: filter,
          value: officeSelect,
        };
        break;

      case "building":
        type = {
          type: filter,
          value: buildingSelect,
        };
        break;
      default:
        type = "";
        break;
    }
    sendAjaxRequest({
      dateFilter: date,
      Filter: filter,
      search: search,
      type: type,
      officeSelect: officeSelect,
      buildingSelect: buildingSelect,
      roomSelect: roomSelect,
    });

    // Fechar o modal
    $("#SelectModal").modal("hide");
  });

  // Call the function to fetch rooms
  const fetchOffices = async () => {
    try {
      const response = await fetch("fetch_offices.php");
      const data = await response.text();
      const officeDropdown = document.getElementById("officeSelect2");
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
  const needsFetchRooms = document.body.dataset.needsFetchRooms === "true";

  if (needsFetchRooms) {
    initDropdowns();
  }
});

$(document).ready(function () {
  const department_id = $("#department").val();
  updateRoles(department_id);

  $("#department").change(function () {
    const department_id = $(this).val();
    updateRoles(department_id);
  });
});

function updateRoles(departmentId) {
  $.ajax({
    url: "get_roles.php",
    method: "GET",
    data: {
      department_id: departmentId,
    },
    success: function (response) {
      $("#role").html(response);
    },
    error: function (response) {
      console.error(response);
    },
  });
}
