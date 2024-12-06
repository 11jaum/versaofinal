<?php
include("connection/connect.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$consultaId = $data['id'] ?? null;

if ($consultaId) {
    $stmt = $con->prepare("UPDATE consulta SET status = 'aceita' WHERE id = ?");
    $stmt->bind_param("i", $consultaId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao aceitar a consulta.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID inválido.']);
}

$con->close();
?>
