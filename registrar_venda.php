<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Venda</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
    <h2>Registrar Venda</h2>
    <form method="POST" action="salvar_venda.php">    
        <input type="text" name="nome_produto" placeholder="Nome do Produto" required autocomplete="off">
        <div id="sugestoes" style="border: 1px solid #ccc; display: none;"></div>
        <input type="number" name="qtde_vendida" placeholder="Quantidade Vendida" required>
        <input type="date" name="data_venda" required>
        <input type="submit" value="Registrar Venda">
    </form>
    <a href="menu_principal.php"><button>Voltar ao Menu Inicial</button></a>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("input[name='nome_produto']").on("keyup", function() {
        let valor = $(this).val();
        if (valor.length >= 3) {
            $.get("buscar_produto.php", { termo: valor }, function(data) {
                $("#sugestoes").html(data).show();
            });
        } else {
            $("#sugestoes").hide();
        }
    });
});

function selecionarProduto(id, nome) {
    $("input[name='nome_produto']").val(nome);
    $("#sugestoes").hide();
}
</script>

</body>
</html>
<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}
?>


