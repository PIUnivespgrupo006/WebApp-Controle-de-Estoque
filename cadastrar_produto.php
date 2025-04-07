<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura e sanitiza os dados recebidos
    $nome_produto = htmlspecialchars($_POST['nome_produto']);
    $qtde_inicial = intval($_POST['qtde_inicial']);

    // Verifica se os campos foram preenchidos corretamente
    if (!empty($nome_produto) && $qtde_inicial >= 0) {
        // Usando prepared statement para evitar SQL Injection
        $stmt = $conexao->prepare("INSERT INTO produtos (nome_produto, qtde_estoque) VALUES (?, ?)");
        $stmt->bind_param("si", $nome_produto, $qtde_inicial);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
        } else {
            echo "<p style='color: red;'>Erro ao cadastrar produto: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Preencha todos os campos corretamente.</p>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Novo Produto</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h2>Cadastrar Novo Produto</h2>
    <form method="POST">
        Nome do Produto: <input type="text" name="nome_produto" required><br>
        Quantidade Inicial: <input type="number" name="qtde_inicial" required><br>
        <input type="submit" value="Cadastrar">
    </form>

    <br>
    <a href="index.php"><button>Voltar ao Menu Inicial</button></a>
</body>
</html>

