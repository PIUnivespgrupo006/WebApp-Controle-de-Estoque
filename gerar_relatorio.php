<?php
$conexao = include 'conexao.php'; // <-- Isso corrige o problema!

$dias = (int)$_GET['dias'];

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="relatorio_vendas_' . $dias . '_dias.xls"');
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th>ID Venda</th><th>Produto</th><th>Quantidade</th><th>Data da Venda</th></tr>";

$sql = "SELECT id_venda, nome_produto, qtde_vendida, data_venda 
        FROM vendas 
        WHERE data_venda >= CURDATE() - INTERVAL $dias DAY 
        ORDER BY data_venda DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<tr><td colspan='4'>Erro ao gerar relatório: " . mysqli_error($conn) . "</td></tr>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_venda'] . "</td>";
        echo "<td>" . $row['nome_produto'] . "</td>";
        echo "<td>" . $row['qtde_vendida'] . "</td>";
        echo "<td>" . $row['data_venda'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";
mysqli_close($conn);
exit;
?>
