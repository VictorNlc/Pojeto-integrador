<?php
// Iniciar a sessão
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'perfil');

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter todos os usuários cadastrados, exceto o usuário logado
$usuario_id = $_SESSION['id'];
$sql = "SELECT id, nome, foto_perfil FROM usuarios WHERE id != $usuario_id";
$result = $conn->query($sql);

// Verificar se há usuários cadastrados
if ($result->num_rows == 0) {
    echo "Não há contatos disponíveis.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contatos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contatos-container">
        <h1>Contatos</h1>
        
        <?php while ($usuario = $result->fetch_assoc()): ?>
            <div class="perfil-contato">
                <img src="<?php echo htmlspecialchars($usuario['foto_perfil']) ?: 'default.jpg'; ?>" alt="Foto de perfil">
                <p><?php echo htmlspecialchars($usuario['nome']); ?></p>
                <a href="perfil.php?id=<?php echo $usuario['id']; ?>">Ver Perfil</a>
            </div>
        <?php endwhile; ?>
        
    </div>
</body>
</html>
