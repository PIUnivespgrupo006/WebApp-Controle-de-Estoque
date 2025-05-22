<?php
include 'conexao.php';

if (isset($_GET['termo'])) {
    $nome_produto = $_GET['termo'];

    $sql = "SELECT id_produto, nome_produto FROM produtos 
            WHERE nome_produto LIKE ? LIMIT 5";

    $stmt = $conn->prepare($sql);
    $like = "%$nome_produto%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {
            echo "<div onclick=\"selecionarProduto('{$linha['id_produto']}', '{$linha['nome_produto']}')\">
                    {$linha['nome_produto']}
                  </div>";
        }
    } else {
        echo "<div>Produto não encontrado.</div>";
    }
}
?>

