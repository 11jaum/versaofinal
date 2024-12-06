<?php
    include("connection/connect.php");

    function timing($time) {
        $time = time() - $time;
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'ano',
            2592000 => 'mês',
            604800 => 'semana',
            86400 => 'dia',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            if ($text == "segundo") {
                return "agora mesmo";
            }
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }

    if (isset($_COOKIE["ID"]) && isset($_COOKIE["TOKEN"]) && isset($_COOKIE["SECURE"])) {
        // Normalização e validação básica
        $id = filter_var($_COOKIE["ID"], FILTER_VALIDATE_INT);
        $token = filter_var($_COOKIE["TOKEN"], FILTER_SANITIZE_STRING);
        $secure = filter_var($_COOKIE["SECURE"], FILTER_VALIDATE_INT);

        if (!$id || !$token || !$secure) {
            // Expira cookies e redireciona
            setcookie("ID", "", time() - 3600, "/");
            setcookie("TOKEN", "", time() - 3600, "/");
            setcookie("SECURE", "", time() - 3600, "/");
            header("Location: auth.html");
            exit();
        }

        // Consulta
        $stmt = $con->prepare("SELECT Id, Username, Picture, Online, Creation FROM User WHERE Id = ? AND Token LIKE ? AND Secure = ? LIMIT 1");
        $stmt->bind_param("isi", $id, $token, $secure);
        $stmt->execute();
        $me = $stmt->get_result()->fetch_assoc();

        if (!$me) {
            // Expira cookies e redireciona caso o usuário não seja encontrado
            setcookie("ID", "", time() - 3600, "/");
            setcookie("TOKEN", "", time() - 3600, "/");
            setcookie("SECURE", "", time() - 3600, "/");
            header("Location: auth.html");
            exit();
        } else {
            // Informações do usuário
            $uid = $me["Id"];
            $username = $me["Username"];
            $user_picture = $me["Picture"];
            $user_online = strtotime($me["Online"]);
            $user_creation = $me["Creation"];

            // Atualização do status de online do usuário
            $stmt = $con->prepare("UPDATE User SET `Online` = NOW() WHERE Id = ?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
        }
    } else {
        // Expira cookies e redireciona caso os cookies não estejam definidos
        setcookie("ID", "", time() - 3600, "/");
        setcookie("TOKEN", "", time() - 3600, "/");
        setcookie("SECURE", "", time() - 3600, "/");
        header("Location: auth.html");
        exit();
    }

?>
