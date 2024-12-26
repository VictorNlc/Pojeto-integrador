<?php
$dsn = 'mysql:host=localhost;dbname=projeto';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['login'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE login = ? OR email = ?');
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('Esse login ou e-mail já existe'); window.location.href='cadastro.html';</script>";
        die();
    }

    $stmt = $pdo->prepare('INSERT INTO usuarios (login, email, senha) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $password]);

    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.html';</script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>