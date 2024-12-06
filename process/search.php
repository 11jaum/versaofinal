<?php
include("check.php");
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    die('<p class="noResults">Usuário não autenticado.</p>');
}

// Obtém o nome de usuário
$username = $_SESSION['username'];

// Determina se o usuário é um psicólogo
$isPsychologist = stripos($username, 'Psi') === 0;

// Processa a pesquisa
if (isset($_GET["term"])) {
    // Validação do termo de pesquisa
    $searchTerm = trim($_GET["term"]);
    if (empty($searchTerm)) {
        echo '<p class="noResults">Digite um termo para pesquisar.</p>';
        exit;
    }

    // Escapa a entrada para evitar SQL Injection
    $searchTerm = mysqli_real_escape_string($con, $searchTerm);

    // Prepara a consulta com ou sem limite, dependendo do tipo de usuário
    if ($isPsychologist) {
        $query = "
            SELECT Id, Username, Picture 
            FROM User 
            WHERE Username LIKE CONCAT('%', ?, '%') 
            ORDER BY Username DESC
        ";
    } else {
        $query = "
            SELECT Id, Username, Picture 
            FROM User 
            WHERE Username LIKE CONCAT('%', ?, '%') 
            ORDER BY Username DESC 
            LIMIT 10
        ";
    }

    // Prepara e executa a consulta
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die('<p class="noResults">Erro na preparação da consulta: ' . $con->error . '</p>');
    }
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se a consulta retornou resultados
    if ($result->num_rows < 1) {
        echo '<p class="noResults">Sem resultados</p>';
    } else {
        // Exibe os resultados
        while ($user = $result->fetch_assoc()) {
            ?>
            <div class="row" onclick="$('#searchContainer').hide(); chat('<?php echo $user['Id']; ?>');">
                <img src="profilePics/<?php echo htmlspecialchars($user["Picture"]); ?>" alt="Foto de perfil" />
                <p><?php echo htmlspecialchars($user["Username"]); ?></p>
            </div>
            <?php
        }
    }

    // Libera recursos
    $stmt->close();
} else {
    echo '<p class="noResults">Termo de pesquisa não informado.</p>';
}
?>
