<?php
session_start(); // Inicia a sessão

$host = 'localhost'; // ou o IP do seu servidor de banco de dados
$dbname = 'agendador';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $CPF = $_POST['CPF'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE CPF = :CPF");
    $stmt->execute(['CPF' => $CPF]);
    $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

    //Verifica se o CPF está cadastrado no Banco
    if (!$userdata) {
        // CPF não está cadastrado
       echo "<script>alert('CPF não cadastrado! Crie uma conta.'); window.location.href = 'Login.html';</script>";
        exit;
    }
    //verificação de CPF e senha no Banco para realizar o login
    if ($userdata && $senha == $userdata['senha']) {
        // Login bem-sucedido
        $_SESSION['CPF'] = $CPF;
        header("Location: agendamento.php");
        exit;
    } else {

        //Falha de login, senha incorreta
        echo "<script>alert('Senha incorreta! Tente novamente.'); window.location.href = 'Login.html';</script>";
       
    }
    //apresentar erro caso não conecte no banco de dados
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }

?>
