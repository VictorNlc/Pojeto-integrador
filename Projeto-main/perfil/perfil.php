<?php
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../formulario-de-login-html-css/login.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'projeto');

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$usuario_id = $_SESSION['user_id'];
$perfil_id = isset($_GET['id']) ? intval($_GET['id']) : $usuario_id;

$usuario = $conn->query("SELECT * FROM usuarios WHERE ID=$perfil_id")->fetch_assoc();
if (!$usuario) {
    die("Usuário não encontrado.");
}

// Adicionar Foto ao Feed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_feed']) && $usuario_id === $perfil_id) {
    // Adicionar Foto ao Feed
    $diretorio_base_feed = __DIR__ . "/uploads/feed/";
    if (!is_dir($diretorio_base_feed)) {
        mkdir($diretorio_base_feed, 0777, true);
    }

    $foto_feed_nome = basename($_FILES['foto_feed']['name']);
    $caminho_feed_completo = $diretorio_base_feed . $foto_feed_nome;

    // Verifica se o arquivo enviado é uma imagem
    $check = getimagesize($_FILES['foto_feed']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['foto_feed']['tmp_name'], $caminho_feed_completo)) {
            $caminho_feed_relativo = "uploads/feed/" . $foto_feed_nome;
            $descricao_foto = isset($_POST['descricao_foto']) ? $_POST['descricao_foto'] : '';

            // Inserir publicação no banco de dados
            $query_insert_feed = $conn->prepare("INSERT INTO fotos_feed (usuario_id, caminho_foto, descricao) VALUES (?, ?, ?)");
            $query_insert_feed->bind_param("iss", $usuario_id, $caminho_feed_relativo, $descricao_foto);

            if ($query_insert_feed->execute()) {
                echo "Foto adicionada ao feed com sucesso!";
                header("Location: perfil.php?id=$perfil_id"); // Redireciona para atualizar a página
                exit();
            } else {
                echo "Erro ao adicionar foto ao feed: " . $query_insert_feed->error;
            }
        } else {
            echo "Erro ao enviar a foto para o feed.";
        }
    } else {
        echo "O arquivo não é uma imagem válida.";
    }
}

// Editar foto do feed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_descricao']) && isset($_POST['foto_feed_id']) && $usuario_id === $perfil_id) {
    $foto_feed_id = intval($_POST['foto_feed_id']);
    $nova_descricao = $_POST['nova_descricao'];

    // Atualizar a descrição no banco de dados
    $query_update_feed = $conn->prepare("UPDATE fotos_feed SET descricao=? WHERE id=? AND usuario_id=?");
    $query_update_feed->bind_param("sii", $nova_descricao, $foto_feed_id, $usuario_id);
    if ($query_update_feed->execute()) {
        echo "Descrição atualizada com sucesso!";
        header("Location: perfil.php?id=$perfil_id"); // Redireciona para atualizar a página
        exit();
    } else {
        echo "Erro ao atualizar a descrição: " . $query_update_feed->error;
    }
}

// Consultar as fotos do feed
$fotos_feed = $conn->query("SELECT * FROM fotos_feed WHERE usuario_id=$perfil_id ORDER BY data_upload DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="perfil-container">
        <h1>Perfil de <?php echo htmlspecialchars($usuario['login']); ?></h1>

        <div class="feed">
        <div class="back-button">
            <a href="../index.php">
                <button>Voltar para o Início</button>
            </a>
        </div>
            <h3>Feed de Fotos</h3>
            
            <?php while ($foto = $fotos_feed->fetch_assoc()): ?>
                <div class="foto-feed-item">
                    <img src="<?php echo htmlspecialchars($foto['caminho_foto']); ?>" alt="Foto do feed">
                    <p><?php echo htmlspecialchars($foto['descricao']); ?></p>

                    <?php if ($usuario_id === $perfil_id): ?>
                        <!-- Botão de Editar -->
                        <a href="#editar<?php echo $foto['id']; ?>" class="editar-link">Editar</a>

                        <!-- Formulário de edição de descrição -->
                        <div id="editar<?php echo $foto['id']; ?>" class="editar-formulario" style="display:none;">
                            <form action="" method="POST">
                                <input type="hidden" name="foto_feed_id" value="<?php echo $foto['id']; ?>">
                                <textarea name="nova_descricao" rows="4" cols="50"><?php echo htmlspecialchars($foto['descricao']); ?></textarea>
                                <button type="submit" name="editar_descricao">Atualizar Descrição</button>
                            </form>
                        </div>

                        <script>
                            document.querySelector(".editar-link").addEventListener("click", function(event) {
                                event.preventDefault();
                                document.querySelector("#editar<?php echo $foto['id']; ?>").style.display = "block";
                            });
                        </script>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>

            <?php if ($usuario_id === $perfil_id): ?>
                <div class="adicionar-foto-feed">
                    <h3>Adicionar Foto ao Feed</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="file" name="foto_feed" required>
                        <textarea name="descricao_foto" rows="4" cols="50" placeholder="Adicione uma descrição à foto..."></textarea>
                        <button type="submit">Adicionar Publicação</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
