<?php
include("connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $nome_psicologo = mysqli_real_escape_string($con, $_POST['nome_psicologo']);
    $cpf_psicologo = mysqli_real_escape_string($con, $_POST['cpf_psicologo']);
    $especialidade = mysqli_real_escape_string($con, $_POST['especialidade']);
    $crp = mysqli_real_escape_string($con, $_POST['crp']);
    $email = mysqli_real_escape_string($con, $_POST['contato']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $disponibilidade = mysqli_real_escape_string($con, $_POST['disponibilidade']);

    // Validations (Ex: check if required fields are not empty)
    if (empty($nome_psicologo) || empty($cpf_psicologo) || empty($especialidade) || empty($crp) || empty($email) || empty($descricao) || empty($disponibilidade)) {
        echo json_encode(['status' => 'error', 'message' => 'Todos os campos obrigatórios devem ser preenchidos!']);
        exit;
    }

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO psicologos (nome_psicologo, cpf_psicologo, especialidade, crp, disponibilidade, email, descricao) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome_psicologo, $cpf_psicologo, $especialidade, $crp, $disponibilidade, $email, $descricao);

    // Execute the statement
    if ($stmt->execute()) {
        // Success
        echo json_encode(['status' => 'success', 'message' => 'Psicólogo registrado com sucesso!']);
    } else {
        // Error
        echo json_encode(['status' => 'error', 'message' => 'Erro ao registrar psicólogo. Erro: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($con);
}
?>

