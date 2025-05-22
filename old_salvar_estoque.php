<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}

// Inicializa variável de mensagem
$mensagem = "";

// Processa o formulário se for envio POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexao.php");

    $nome_produto = $_POST["nome_produto"];
    $quantidade = intval($_POST["quantidade"]);

    $sql_verifica = "SELECT * FROM produtos WHERE nome_produto = ?";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->bind_param("s", $nome_produto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $sql_update = "UPDATE produtos SET qtde_estoque = qtde_estoque + ? WHERE nome_produto = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("is", $quantidade, $nome_produto);

        if ($stmt->execute()) {
            $mensagem = "✅ Estoque atualizado para o produto: <strong>$nome_produto</strong>.";
        } else {
            $mensagem = "❌ Erro ao atualizar estoque: " . $stmt->error;
        }
    } else {
        $mensagem = "⚠️ Produto <strong>$nome_produto</strong> não encontrado.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Estoque</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .mensagem {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
        }
        .mensagem.sucesso {
            background-color: #d4edda;
            color: #155724;
        }
        .mensagem.erro {
            background-color: #f8d7da;
            color: #721c24;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"], .btn-voltar {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover, .btn-voltar:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Adicionar Estoque</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem <?= strpos($mensagem, '✅') !== false ? 'sucesso' : 'erro' ?>">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nome_produto" placeholder="Nome do Produto" required>
        <input type="number" name="quantidade" placeholder="Quantidade a Adicionar" min="1" required>
        <input type="submit" value="Adicionar">
    </form>
    <br>
    <a href="menu_principal.php"><button class="btn-voltar">Voltar ao Menu Inicial</button></a>
</div>
</body>
</html>
