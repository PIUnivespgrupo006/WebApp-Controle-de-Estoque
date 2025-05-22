<?php
// Ativa exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["usuario"])) {
    $_SESSION["usuario"] = "teste"; // simula login temporário
}

// Só mostra a interface se não houver requisição GET
if (!isset($_GET['gerar'])) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Teste Relatório</title>
    </head>
    <body>
        <h2>Teste de Relatório</h2>
        <form method="GET" action="">
            <label for="dias">Período:</label>
            <select name="dias" id="dias">
                <option value="10">Últimos 10 dias</option>
                <option value="30">Últimos 30 dias</option>
            </select>
            <button type="submit" name="gerar" value="1">Gerar</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

// Se chegou aqui, vai gerar o arquivo
require_once 'conexao.php';

$dias = (int)$_GET['dias'];
$sql = "SELECT id_venda, nome_produto, qtde_vendida, data_venda 
        FROM vendas 
        WHERE data_venda >= CURDATE() - INTERVAL ? DAY 
        ORDER BY data_venda DESC";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $dias);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Erro ao gerar relatório: " . mysqli_error($conexao));
}

// Cabeçalhos para download
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Disposition: attachment; filename=relatorio_{$dias}dias.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tabela
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Produto</th><th>Quantidade</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['id_venda']}</td>";
    echo "<td>{$row['nome_produto']}</td>";
    echo "<td>{$row['qtde_vendida']}</td>";
    echo "<td>{$row['data_venda']}</td>";
    echo "</tr>";
}
echo "</table>";
exit;
