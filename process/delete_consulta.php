<?php
// Conectar ao banco de dados
include("connection/connect.php");

// Receber os dados via POST
$data = json_decode(file_get_contents('php://input'), true);
$consultaId = $data['id'];

// Verificar se o ID foi enviado
if (isset($consultaId)) {
    // Deletar a consulta com o ID correspondente
    $sql = "DELETE FROM consulta WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $consultaId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir a consulta.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID inválido.']);
}

mysqli_close($con);
?>
