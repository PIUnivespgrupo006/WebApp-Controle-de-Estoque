<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produto'], $_POST['qtde_adicionada'])) {
    $id_produto = $_POST['id_produto'];
    $qtde_adicionada = $_POST['qtde_adicionada'];

    if (!empty($id_produto) && is_numeric($qtde_adicionada)) {
        $sql = "UPDATE produtos SET qtde_estoque = qtde_estoque + $qtde_adicionada WHERE id_produto = '$id_produto'";

        if ($conexao->query($sql) === TRUE) {
            echo "<p class='mensagem-sucesso'>Quantidade adicionada com sucesso!</p>";
        } else {
            echo "<p class='mensagem-erro'>Erro ao adicionar quantidade: " . $conexao->error . "</p>";
        }
    } else {
        echo "<p class='mensagem-erro'>Erro: Preencha todos os campos corretamente.</p>";
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Estoque</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Adicionar Estoque</h2>
        <form method="POST">
            Nome do Produto: 
            <input type="text" id="nome_produto" name="nome_produto" onkeyup="buscarProduto()" required>
            <input type="hidden" id="id_produto" name="id_produto">

            <div id="sugestoes"></div>

            Quantidade a Adicionar: <input type="number" name="qtde_adicionada" required><br>
            <input type="submit" value="Adicionar" class="botao">
        </form>

        <br>
       

        <br>
        <a href="index.php"><button class="botao">Voltar ao Menu Inicial</button></a>
    </div>

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
