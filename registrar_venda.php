<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['id_produto'];
    $qtde_vendida = $_POST['qtde_vendida'];
    $data_venda = $_POST['data_venda'];

    $sql = "INSERT INTO vendas (id_produto, nome_produto, qtde_vendida, data_venda)
            SELECT id_produto, nome_produto, $qtde_vendida, '$data_venda'
            FROM produtos
            WHERE id_produto = '$id_produto'";

if ($conexao->query($sql) === TRUE) {
    // Atualizar o estoque
    $sql_atualizar = "UPDATE produtos 
                      SET qtde_estoque = qtde_estoque - $qtde_vendida 
                      WHERE id_produto = '$id_produto'";

    if ($conexao->query($sql_atualizar) === TRUE) {
        echo "Venda registrada e estoque atualizado com sucesso!";
    } else {
        echo "Venda registrada, mas erro ao atualizar o estoque: " . $conexao->error;
    }

    //echo "<br><a href='index.php'><button>Voltar ao Menu Inicial</button></a>";
} else {
    echo "Erro ao registrar venda: " . $conexao->error;
}

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Venda</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <a href="index.php"><button>Voltar ao Menu Inicial</button></a>
    <h2>Registrar Nova Venda</h2>
    <form method="POST">
    Nome do Produto: 
    <input type="text" id="nome_produto" name="nome_produto" onkeyup="buscarProduto()" required>
    <input type="hidden" id="id_produto" name="id_produto">

    <div id="sugestoes"></div>

    Quantidade Vendida: <input type="number" name="qtde_vendida" required><br>
    Data da Venda: <input type="date" name="data_venda" required><br>

    <input type="submit" value="Registrar">
</form>


    <script>
        function buscarProduto() {
            const nomeProduto = $('#nome_produto').val();
            if (nomeProduto.length >= 2) {
                $.ajax({
                    url: 'buscar_produto.php',
                    method: 'POST',
                    data: { nome_produto: nomeProduto },
                    success: function(response) {
                        $('#sugestoes').html(response);
                    }
                });
            } else {
                $('#sugestoes').html('');
            }
        }

        function selecionarProduto(id, nome) {
            $('#id_produto').val(id);
            $('#nome_produto').val(nome);
            $('#sugestoes').html('');
        }
    </script>
</body>
</html>
