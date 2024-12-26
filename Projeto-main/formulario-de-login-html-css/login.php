<?php
session_start(); // Inicia a sessão
$dsn = 'mysql:host=localhost;dbname=projeto';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Transformando a senha digitada em hash SHA1
        $hashedPassword = sha1($password);

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Comparando a senha hasheada com a senha armazenada
            if ($hashedPassword === $user['senha']) {
                
                // Armazena informações do usuário na sessão
                $_SESSION['user_id'] = $user['ID']; 
                
                $_SESSION['user_email'] = $user['email'];
                var_dump($_SESSION);
                // Redireciona diretamente para a página inicial
                header("Location: ../index.php");
                exit(); // Encerra o script após o redirecionamento
            } else {
                // Redireciona para a página de login em caso de senha incorreta
                header("Location: login.html?error=senha_incorreta");
                exit();
            }
        } else {
            // Redireciona para a página de cadastro se o e-mail não estiver registrado
            header("Location: cadastro.html?error=email_nao_registrado");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>