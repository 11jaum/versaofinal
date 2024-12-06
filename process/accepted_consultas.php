<?php
include("connection/connect.php");

if (mysqli_connect_errno()) {
    echo json_encode(["error" => "Falha ao se conectar: " . mysqli_connect_error()]);
    exit();
}

// Query para buscar todas as consultas aceitas
$sql = "SELECT nome, data_consulta, hora, descricao, contato 
        FROM consulta 
        WHERE status = 'aceita'";

$result = mysqli_query($con, $sql);

// Verifica se houve erro na execução da consulta
if (!$result) {
    echo json_encode(["error" => "Erro na consulta: " . mysqli_error($con)]);
    exit();
}

// Busca todos os resultados no banco
$consultas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Verifica se há resultados e retorna como JSON
if (empty($consultas)) {
    echo json_encode(["message" => "Nenhuma consulta aceita encontrada."]);
} else {
    echo json_encode($consultas);
}

// Fecha a conexão com o banco de dados
mysqli_close($con);
?>
