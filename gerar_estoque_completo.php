<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'conexao.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="estoque_completo.xls"');

echo "<table border='1'>";
echo "<tr><th>Produto</th><th>Quantidade em Estoque</th></tr>";

$sql = "SELECT nome_produto, qtde_estoque FROM produtos ORDER BY nome_produto";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['nome_produto'] . "</td>";
    echo "<td>" . $row['qtde_estoque'] . "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);
?>
