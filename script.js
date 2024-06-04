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

  const fetchOfficeDetails = async () => {
    try {
      const response = await fetch(`office_details.php`);
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details:", e.message);
    }
  };
  const fetchbuildingsDetails = async () => {
    try {
      const response = await fetch(`building_details.php`);
      const data = await response.text();
      const buildingContent = document.getElementById("buildingContent");
      buildingContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching building details:", e.message);
    }
  };
  
  const fetchbuildingsdetailsforbuilding = async (selectedBuildingId) => {
    try {
      const response = await fetch(
        `building_details.php?selectedBuildingId=${encodeURIComponent(
          selectedBuildingId
        )}`
      );
      const data = await response.text();
      const buildingContent = document.getElementById("buildingContent");
      buildingContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching building details for building:", e.message);
    }
  };
  const fetchOfficeDetailsForOffice = async (officeID) => {
    try {
      const response = await fetch(
        `office_details.php?officeId=${encodeURIComponent(officeID)}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details with others:", e.message);
    }
  };

  const fetchOfficeDetailsForBuilding = async (buildingId) => {
    try {
      const response = await fetch(
        `office_details.php?selectedBuildingId=${encodeURIComponent(
          buildingId
        )}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details with others:", e.message);
    }
  };
  const initDropdowns = async () => {
    try {
      await fetchOffices();
      await fetchBuildings();
      await fetchOfficeDetails();
      await fetchbuildingsDetails();

      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.addEventListener("change", async (event) => {
        const selectedOfficeId = event.target.value;
        try {
          await fetchOfficeDetailsForOffice(selectedOfficeId);
        } catch (e) {
          console.trace("Message");
          console.error("Error fetching dropdown:", e.message);
        }
        console.log(selectedOfficeId);
      });

      const buildingDropdown = document.getElementById("buildingSelect");
      buildingDropdown.addEventListener("change", async (event) => {
        const selectedBuildingId = event.target.value;
        try {
          await fetchOfficeDetailsForBuilding(selectedBuildingId);
          await fetchOfficesForBuilding(selectedBuildingId);
          await fetchbuildingsdetailsforbuilding(selectedBuildingId);
        } catch (e) {
          console.error("Error fetching offices for building:", e.message);
        }
        console.log(selectedBuildingId);
      });
      officeDropdown.addEventListener("change", () => {
        fetchOfficeDetails();
        // Para atualizar o conteúdo do officeContent
        document.getElementById("officeContent").innerHTML = "";
      });
      buildingDropdown.addEventListener("change", () => {
        fetchbuildingsDetails();
        document.getElementById("buildingContent").innerHTML = "";
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
  $("#filterButton").click(function () { 
    triggerAjaxRequest();
   });
  const date = $("#dateFilter").val();

  // Enviar a requisição AJAX inicial
  sendAjaxRequest({
    date: date,
  });

  // Vincula os eventos de input
  bindInputEvents();

  function bindInputEvents() {
    $("#dateFilter, #marksearch, #filter, #active").on("input", function () {
      triggerAjaxRequest();
    });


  }

  function triggerAjaxRequest() {
    const dateFilter = $("#dateFilter").val();
    const search = $("#marksearch").val();
    const active = $("#active").is(":checked") ? 1 : 0;
    const officeSelect = $("#officeSelect").val();
    const buildingSelect = $("#buildingSelect").val();
    const roomSelect = $("#roomSelect").val();
    const filter = $("#filterButton").val();

    let type;
    switch (filter) {
      case "room":
        type = { type: filter, value: roomSelect };
        break;
      case "office":
        type = { type: filter, value: officeSelect };
        break;
      case "building":
        type = { type: filter, value: buildingSelect };
        break;
      default:
        type = "";
        break;
    }

    sendAjaxRequest({
      dateFilter: dateFilter,
      Filter: filter,
      search: search,
      active: active,
      type: type,
      // officeSelect: officeSelect,
      // buildingSelect: buildingSelect,
      // roomSelect: roomSelect,
    });
    $("#SelectModal").modal("hide");
  }

  function sendAjaxRequest(data) {
    $.ajax({
      type: "GET",
      url: "reserves_list.php",
      data: data,
      success: function (response) {
        $("#markList").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching room list:", error);
      },
    });
  }

  // Call the function to fetch rooms
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
  const fetchRooms = async () => {
    try {
      const response = await fetch("fetch_room.php");
      const data = await response.text();
      const roomDropdown = document.getElementById("roomSelect");
      roomDropdown.innerHTML = data;
    } catch (e) {
      console.error("Error fetching rooms:", e.message);
    }
  };
  const fetchOfficeDetails = async () => {
    try {
      const response = await fetch(`office_details.php`);
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details:", e.message);
    }
  };
  const fetchbuildingsDetails = async () => {
    try {
      const response = await fetch(`building_details.php`);
      const data = await response.text();
      const buildingContent = document.getElementById("buildingContent");
      buildingContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching building details:", e.message);
    }
  };
  

  const fetchRoomDetails = async () => {
    try {
      const response = await fetch(`room_details.php`);
      const data = await response.text();
      const roomContent = document.getElementById("roomContent");
      roomContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details:", e.message);
    }
  };

  const fetchOfficesForBuilding = async (buildingId) => {
   
    try {
      const response = await fetch(`fetch_offices.php?selectedBuildingId=${encodeURIComponent(buildingId)}`);
      const data = await response.text();
      officeSelect.innerHTML = data;
    } catch (e) {
      console.error("Error fetching offices for building:", e.message);
    }
  };
  const fetchroomsforoffices = async (officeID) => {
      try {
        const response = await fetch(`fetch_room.php?officeId=${encodeURIComponent(officeID)}`);
        const data = await response.text();
        roomSelect.innerHTML = data;
    } catch (e) {
      console.error("Error fetching rooms for office:", e.message);
    }
  };
  const fetchbBuildingsdetailsforBuildings = async (selectedBuildingId) => {
    try {
      const response = await fetch(
        `building_details.php?selectedBuildingId=${encodeURIComponent(
          selectedBuildingId
        )}`
      );
      const data = await response.text();
      const buildingContent = document.getElementById("buildingContent");
      buildingContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching building details for building:", e.message);
    }
  };
  const fetchOfficeDetailsForOffice = async (officeID) => {
    try {
      const response = await fetch(
        `office_details.php?officeId=${encodeURIComponent(officeID)}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details with others:", e.message);
    }
  };
  const fetchRoomDetailsForRoom = async (roomID) => {
    try {
      const response = await fetch(
        `room_details.php?roomId=${encodeURIComponent(roomID)}`
      );
      const data = await response.text();
      const roomContent = document.getElementById("roomContent");
      roomContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching room details with others:", e.message);
    }
  };
  const fetchOfficeDetailsForBuilding = async (buildingId) => {
    try {
      const response = await fetch(
        `office_details.php?selectedBuildingId=${encodeURIComponent(
          buildingId
        )}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("officeContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching office details with others:", e.message);
    }
  };
  const fetchRoomDetailsForOffices = async (officeID) => {
    try {
      const response = await fetch(
        `room_details.php?selectedBuildingId=${encodeURIComponent(
          officeID
        )}`
      );
      const data = await response.text();
      const officeContent = document.getElementById("roomContent");
      officeContent.innerHTML = data;
    } catch (e) {
      console.error("Error fetching room details with others:", e.message);
    }
  };
  const initDropdowns = async () => {
    try {
      await fetchOffices();
      await fetchBuildings();
      await fetchRooms();
      await fetchbuildingsDetails();
      await fetchOfficeDetails();
      await fetchRoomDetails();

      const officeDropdown = document.getElementById("officeSelect");
      officeDropdown.addEventListener("change", async (event) => {
        const selectedOfficeId = event.target.value;
        try{
          await fetchOfficeDetailsForOffice(selectedOfficeId);
          await fetchRoomDetailsForOffices(selectedOfficeId);
        } catch (e) {
          console.trace("Message");
          console.error("Error fetching dropdown:", e.message);
        }
        console.log(selectedOfficeId);
      }); 

      const buildingDropdown = document.getElementById("buildingSelect");
      buildingDropdown.addEventListener("change", async (event) => {
        const selectedBuildingId = event.target.value;
        try {
          await fetchOfficesForBuilding(selectedBuildingId);
          await fetchOfficeDetailsForBuilding(selectedBuildingId);
          await fetchbBuildingsdetailsforBuildings(selectedBuildingId);
        } catch (e) {
          console.error("Error fetching offices for building:", e.message);
        }
        console.log(selectedBuildingId);
      });

      const roomDropdown = document.getElementById("roomSelect");
      roomDropdown.addEventListener("change", async (event) => {
        const selectedRoomId = event.target.value;
        try {
          await fetchroomsforoffices(selectedRoomId);
          await fetchRoomDetailsForRoom(selectedRoomId);
        } catch (e) {
          console.error("Error fetching rooms for office:", e.message);
        }
        console.log(selectedRoomId);
      });
      officeDropdown.addEventListener("change", () => {
        fetchOfficeDetails();
        // Para atualizar o conteúdo do officeContent
        document.getElementById("officeContent").innerHTML = "";
      });
      buildingDropdown.addEventListener("change", () => {
        fetchbuildingsDetails();     
         document.getElementById("buildingContent").innerHTML = "";
      });
      roomDropdown.addEventListener("change", () => {
        fetchRoomDetails();
        document.getElementById("roomContent").innerHTML = "";

      });
    }  catch (e) {
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
