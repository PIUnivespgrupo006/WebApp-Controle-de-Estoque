<?php
include 'conexao.php';

if (isset($_POST['nome_produto'])) {
    $nome_produto = $_POST['nome_produto'];

    $sql = "SELECT id_produto, nome_produto FROM produtos 
            WHERE nome_produto LIKE '%$nome_produto%'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {
            echo "<div onclick=\"selecionarProduto('{$linha['id_produto']}', '{$linha['nome_produto']}')\">
                    {$linha['nome_produto']}
                  </div>";
        }
    } else {
        echo "Produto não encontrado.";
    }
}
?>
