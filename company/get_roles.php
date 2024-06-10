<?php
include_once ("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}

$departmentId = (isset($_GET['department_id'])? $_GET['department_id'] : null);


// Consulta SQL para obter as funções disponíveis para o departamento selecionado
$sql = "SELECT rd.roles_department_id, r.role 
        FROM roles_department rd 
        INNER JOIN roles r ON rd.role_id = r.role_id 
        WHERE rd.department_id = ?";

// Prepare a consulta com um parâmetro
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $departmentId);
$stmt->execute();
$result = $stmt->get_result();

$options = "";

if ($departmentId == null){
    if ($row['p.role_department_id'] == null){
        echo '<option value="" selected >Select a Department first</option>';
      }
}
else{
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['roles_department_id'] . "'>" . $row['role'] . "</option>";
    }
} else {
    $options .= "<option value=''>No results found</option>";
}
}
// Retorne a string HTML como resposta
echo $options;

?>