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
    <title>Menu Principal</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Estoque</h1>
        <p>Bem-vindo, <strong><?= $_SESSION["usuario"] ?></strong>! Escolha uma das opções abaixo:</p>
        
        <div class="menu">
            <a href="listar_produtos.php"><button>📦 Excluir Produtos</button></a>
            <a href="cadastrar_produto.php"><button>➕ Cadastrar Produto</button></a>
            <a href="registrar_venda.php"><button>🛒 Registrar Venda</button></a>
            <a href="adicionar_estoque.php"><button>🔼 Adicionar Estoque</button></a>
            <a href="relatorio_vendas.php"><button>📈 Relatório de Vendas</button></a>
            <a href="gerar_estoque_completo.php"><button>📋 Gerar Planilha de Estoque</button></a>
            <a href="relatorio_reposicao.php"><button>📉 Relatório de Reposição</button></a>
            <a href="login.php?logout=true"><button style="background-color: #f44336;">🚪 Sair</button></a>
            
        </div>
    </div>
</body>
</html>
