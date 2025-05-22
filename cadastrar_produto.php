<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Ajustes locais caso não estejam no estilo.css */
        form label,
        form input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            width: auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #388e3c;
        }

        a button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Cadastrar Produto</h1>

        <form action="processa_cadastro.php" method="post">
            <label for="nome_produto">Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" required>

            <label for="qtde_estoque">Quantidade em Estoque:</label>
            <input type="number" id="qtde_estoque" name="qtde_estoque" required>

            <input type="submit" value="Cadastrar">
        </form>

        <a href="menu_principal.php"><button>🔙 Voltar ao Menu</button></a>
    </div>
</body>
</html>
