<?php
include("connection/connect.php");
session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email == "" || $password == "") {
        die(header("HTTP/1.0 401 Preencha todos os campos do formulário"));
    }

    $stmt = $con->prepare("SELECT Id, Username, Password, Token, Secure FROM User WHERE (Email LIKE ? OR Username LIKE ?) LIMIT 1");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['username'] = $user['Username'];
        setcookie("ID", $user['Id'], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("TOKEN", $user['Token'], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("SECURE", $user['Secure'], time() + (10 * 365 * 24 * 60 * 60));

        // Verifica o prefixo do nome de usuário
        if (strpos($user['Username'], 'Psi') === 0) {
            echo json_encode(['redirect' => 'dashboard.html']);
        } else {
            echo json_encode(['redirect' => 'index.html']);
        }
    } else {
        die(header("HTTP/1.0 401 Senha incorreta"));
    }
} else {
    die(header("HTTP/1.0 401 Formulário de autenticação inválido"));
}
?>
