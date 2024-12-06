<?php
// Conectar ao banco de dados
include("connection/connect.php");

// Consultar os dados de suporte
$query = "SELECT * FROM support ORDER BY created_at DESC";
$result = $con->query($query);

// Verificar se há resultados e criar a tabela de suporte
if ($result) {
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nome</th>';
        echo '<th>E-mail</th>';
        echo '<th>Assunto</th>';
        echo '<th>Mensagem</th>';
        echo '<th>Data de envio</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
            echo '<td>' . nl2br(htmlspecialchars($row['message'])) . '</td>';
            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Nenhuma solicitação de suporte encontrada.</p>';
    }
} else {
    echo '<p>Erro na consulta: ' . $con->error . '</p>';
}

// Fechar a conexão com o banco de dados
$con->close();
?>
