<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}

if (isset($_GET['baixar'])) {
    include 'conexao.php';

    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment; filename="relatorio_reposicao.html"');
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<!DOCTYPE html>";
    echo "<html lang='pt-BR'>";
    echo "<head><meta charset='UTF-8'><title>Relatório de Reposição</title>";
    echo "<style>
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style>";
    echo "</head><body>";
    echo "<h1>Relatório de Reposição</h1>";

    $sql = "
    SELECT 
        p.nome_produto,
        p.qtde_estoque,
        ROUND(SUM(v.qtde_vendida) / 3, 2) AS media_vend_mensal,
        GREATEST(CEIL(SUM(v.qtde_vendida) / 3) - p.qtde_estoque, 0) AS qtde_arepor
    FROM 
        produtos p
    JOIN 
        vendas v ON p.nome_produto = v.nome_produto
    WHERE 
        v.data_venda >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
    GROUP BY 
        p.nome_produto, p.qtde_estoque
    HAVING 
        GREATEST(CEIL(SUM(v.qtde_vendida) / 3) - p.qtde_estoque, 0) > 0;

    ";

    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        echo "<p>Erro ao gerar relatório: " . mysqli_error($conn) . "</p>";
    } else {
        if (mysqli_num_rows($resultado) == 0) {
            echo "<p>Nenhum dado encontrado para os últimos 3 meses.</p>";
        } else {
            echo "<table>";
            echo "<tr><th>Produto</th><th>Estoque Atual</th><th>Média Mensal</th><th>Quantidade a Repor</th></tr>";

            while ($linha = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($linha['nome_produto']) . "</td>";
                echo "<td>" . $linha['qtde_estoque'] . "</td>";
                echo "<td>" . $linha['media_vend_mensal'] . "</td>";
                echo "<td>" . $linha['qtde_arepor'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }

    echo "</body></html>";

    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Relatório de Reposição</title>
    <link rel="stylesheet" href="estilo.css" />
</head>
<body>
<div class="container">
    <h1>Sistema de Estoque</h1>
    <p>Bem-vindo, <strong><?= htmlspecialchars($_SESSION["usuario"]) ?></strong>!</p>

    <div class="menu">
        <a href="menu_principal.php"><button>🔙 Voltar ao Menu</button></a>
    </div>

    <div class="conteudo">
        <h2>📦 Relatório de Reposição</h2>
        <form method="GET">
            <button type="submit" name="baixar" value="1" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
                Baixar Relatório de Reposição (HTML)
            </button>
        </form>
    </div>
</div>
</body>
</html>
