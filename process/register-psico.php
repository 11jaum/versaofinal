<?php
include("connection/connect.php");

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repPassword"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $RepPassword = $_POST["repPassword"];

    if ($username == "" || $email == "" || $password == "" || $RepPassword == "") {
        die(header("HTTP/1.0 401 Preencha todos os campos do formulário"));
    }

    // Verifica se o nome de usuário já existe
    $checkUsername = $con->prepare("SELECT Id FROM User WHERE Username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    if ($checkUsername->get_result()->num_rows > 0) {
        die(header("HTTP/1.0 401 Nome de usuário já existente"));
    }

    // Verifica se o e-mail já existe
    $checkEmail = $con->prepare("SELECT Id FROM User WHERE Email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        die(header("HTTP/1.0 401 Conta com este e-mail já existe"));
    }

    if ($password != $RepPassword) {
        die(header("HTTP/1.0 401 As senhas não coincidem"));
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(openssl_random_pseudo_bytes(20));
    $secure = rand(1000000000, 9999999999);

    $stmt = $con->prepare("INSERT INTO User (`Username`, `Email`, `Password`, `Online`, `Token`, `Secure`, `Creation`) 
                            VALUES (?, ?, ?, now(), ?, ?, now())");
    $stmt->bind_param("ssssi", $username, $email, $password, $token, $secure);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        die(header("HTTP/1.0 401 Erro ao inserir no banco de dados"));
    }
} else {
    die(header("HTTP/1.0 401 Formulário inválido"));
}
?>
