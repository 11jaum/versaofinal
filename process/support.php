<?php
include("connection/connect.php"); // Conectar ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar e recuperar os dados do formulário
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validar o e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'E-mail inválido.']);
        exit();
    }

    // Preparar a consulta SQL
    $stmt = $con->prepare("INSERT INTO support (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Executar a consulta e verificar se a inserção foi bem-sucedida
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Formulário de suporte enviado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar o formulário.']);
    }

    // Fechar a conexão
    $stmt->close();
    $con->close();
}
?>
