<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="css/styles_lista_user.css">
</head>
<body>
    <div class="container">
        <!-- Botão para voltar ao index -->
        <div class="back-button">
            <a href="index.php">
                <button>Voltar para o Início</button>
            </a>
        </div>

        <!-- Conteúdo da página -->
        <?php
        session_start();

        // Conexão com o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'projeto');

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Consulta para obter todos os usuários
        $result = $conn->query("SELECT ID, login FROM usuarios");

        // Verifica se há usuários
        if ($result->num_rows > 0) {
            echo "<h1>Lista de Usuários</h1>";
            echo "<ul>";

            // Exibe cada usuário com um botão para acessar o perfil
            while ($usuario = $result->fetch_assoc()) {
                echo "<li>";
                echo "Usuário: " . htmlspecialchars($usuario['login']);
                echo " <a href='perfil/perfil.php?id=" . $usuario['ID'] . "'><button>Ver Perfil</button></a>";
                echo "</li>";
            }

            echo "</ul>";
        } else {
            echo "Nenhum usuário encontrado.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
