<?php
include("check.php");

if (isset($_POST["message"]) && isset($_POST["id"])) {

    // Normalização
    $user_id = $_POST["id"];
    $message = $_POST["message"];
    $image = "";

    // Verificar e processar a imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $username . "_MESSAGE_" . rand(999, 999999) . $_FILES['image']['name'];
        $imagetemp = $_FILES['image']['tmp_name'];
        $imagePath = "../uploads/";
        
        if (is_uploaded_file($imagetemp)) {
            if (!move_uploaded_file($imagetemp, $imagePath . $image)) {
                header("HTTP/1.0 401 Erro ao guardar imagem");
                echo json_encode(["success" => false, "error" => "Erro ao guardar imagem"]);
                exit;
            }
        } else {
            header("HTTP/1.0 401 Erro ao carregar imagem");
            echo json_encode(["success" => false, "error" => "Erro ao carregar imagem"]);
            exit;
        }
    } elseif ($user_id === "" || $message === "") {
        header("HTTP/1.0 401 Escreva uma mensagem");
        echo json_encode(["success" => false, "error" => "Escreva uma mensagem"]);
        exit;
    }

    // Verificar se a conversa existe
    $checkConversation = $con->prepare("SELECT Id FROM `Conversations` WHERE (MainUser = ? AND OtherUser = ?)");
    $checkConversation->bind_param("ii", $uid, $user_id);
    $checkConversation->execute();
    $result = $checkConversation->get_result();
    $count = $result->num_rows;

    if ($count < 1) {
        // Criar conversa do lado do usuário
        $createChat = $con->prepare("INSERT INTO `Conversations` (`MainUser`, `OtherUser`, `Unread`, `Creation`) VALUES (?, ?, 'n', now())");
        $createChat->bind_param("ii", $uid, $user_id);
        if (!$createChat->execute()) {
            header("HTTP/1.0 500 Erro ao criar conversa");
            echo json_encode(["success" => false, "error" => "Erro ao criar a conversa (usuário)"]);
            exit;
        }

        // Criar conversa do lado do outro usuário
        $createChat2 = $con->prepare("INSERT INTO `Conversations` (`MainUser`, `OtherUser`, `Unread`, `Creation`) VALUES (?, ?, 'y', now())");
        $createChat2->bind_param("ii", $user_id, $uid);
        if (!$createChat2->execute()) {
            header("HTTP/1.0 500 Erro ao criar conversa");
            echo json_encode(["success" => false, "error" => "Erro ao criar a conversa (outro usuário)"]);
            exit;
        }
    } else {
        $update = $con->prepare("UPDATE `Conversations` SET Unread = 'y' WHERE (MainUser = ? AND OtherUser = ?)");
        $update->bind_param("ii", $uid, $user_id);
        if (!$update->execute()) {
            header("HTTP/1.0 500 Erro ao atualizar conversa");
            echo json_encode(["success" => false, "error" => "Erro ao atualizar a conversa"]);
            exit;
        }
    }

    // Inserir a mensagem no banco
    $stmt = $con->prepare("INSERT INTO Chat (`Sender`, `Reciever`, `Message`, `Image`, `Creation`) VALUES (?, ?, ?, ?, now())");
    $stmt->bind_param("iiss", $uid, $user_id, $message, $image);
    if (!$stmt->execute()) {
        header("HTTP/1.0 500 Erro ao enviar mensagem");
        echo json_encode(["success" => false, "error" => "Erro ao enviar a mensagem"]);
        exit;
    }

    // Retornar sucesso
    header("HTTP/1.0 200 OK");
    echo json_encode(["success" => true, "message" => "Mensagem enviada com sucesso"]);
    exit;

} else {
    header("HTTP/1.0 401 Faltam parâmetros");
    echo json_encode(["success" => false, "error" => "Parâmetros ausentes"]);
    exit;
}
