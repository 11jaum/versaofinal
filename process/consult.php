<?php
// Conectar ao banco de dados
include("connection/connect.php");

if (mysqli_connect_errno()) {
    echo json_encode(["error" => "Falha ao se conectar: " . mysqli_connect_error()]);
    exit();
}

// Sanitize and retrieve form data
$username_consulta = mysqli_real_escape_string($con, $_POST['username_consulta']);
$name_consulta = mysqli_real_escape_string($con, $_POST['name_consulta']);
$email_consulta = mysqli_real_escape_string($con, $_POST['email']);
$date = mysqli_real_escape_string($con, $_POST['date']);
$time = mysqli_real_escape_string($con, $_POST['time']);
$text = mysqli_real_escape_string($con, $_POST['text']);
$contato = mysqli_real_escape_string($con, $_POST['contato'] ?? null);

// Verificar se já existe uma consulta agendada com o mesmo nome de usuário
$checkExistingQuery = "SELECT id FROM consulta WHERE username = '$username_consulta' AND nome = '$name_consulta'";
$existingResult = mysqli_query($con, $checkExistingQuery);

if (mysqli_num_rows($existingResult) > 0) {
    // Se existir uma consulta já marcada com o mesmo nome de usuário, retorna um erro
    echo json_encode(['status' => 'error', 'message' => 'Já existe uma consulta marcada com este usuário.']);
} else {
    // Check if the username exists in the User table
    $checkUserQuery = "SELECT Id FROM User WHERE Username = '$username_consulta'";
    $result = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($result) > 0) {
        // User exists, proceed to insert data
        $sql = "INSERT INTO consulta (username, nome, email, data_consulta, hora, descricao, contato)
                VALUES ('$username_consulta', '$name_consulta', '$email_consulta', '$date', '$time', '$text', '$contato')";

        if (mysqli_query($con, $sql)) {
            // Success
            echo json_encode(['status' => 'success', 'message' => 'Consulta marcada com sucesso!']);
        } else {
            // Error inserting into consulta
            echo json_encode(['status' => 'error', 'message' => 'Erro ao marcar consulta.']);
        }
    } else {
        // User does not exist
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado na tabela de usuários.']);
    }
}

// Close connection
mysqli_close($con);
?>
