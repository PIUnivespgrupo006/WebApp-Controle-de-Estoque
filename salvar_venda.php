<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sistema_login.php");
    exit;
}

// Conexão com o banco
$host = 'sql201.infinityfree.com';
$usuario = 'if0_39007414';
$senha = 'SibfxkGyuneA6';
$banco = 'if0_39007414_bdcontroleestoque';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome_produto = $_POST['nome_produto'];
$qtde_vendida = $_POST['qtde_vendida'];
$data_venda = $_POST['data_venda'];

// Buscar o produto no banco de dados
$sql_busca = "SELECT id_produto, qtde_estoque FROM produtos WHERE nome_produto = ?";
$stmt_busca = $conn->prepare($sql_busca);
$stmt_busca->bind_param("s", $nome_produto);
$stmt_busca->execute();
$result = $stmt_busca->get_result();

if ($produto = $result->fetch_assoc()) {
    $id_produto = $produto['id_produto'];
    $estoque_atual = $produto['qtde_estoque'];

    if ($estoque_atual >= $qtde_vendida) {
        // Inserir a venda
        $sql_venda = "INSERT INTO vendas (id_produto, nome_produto, qtde_vendida, data_venda) VALUES (?, ?, ?, ?)";
        $stmt_venda = $conn->prepare($sql_venda);
        $stmt_venda->bind_param("isis", $id_produto, $nome_produto, $qtde_vendida, $data_venda);
        $stmt_venda->execute();

        // Atualizar o estoque
        $novo_estoque = $estoque_atual - $qtde_vendida;
        $sql_update = "UPDATE produtos SET qtde_estoque = ? WHERE id_produto = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $novo_estoque, $id_produto);
        $stmt_update->execute();

        header("Location: registrar_venda.php?sucesso=1");
    } else {
        echo "Erro: estoque insuficiente.";
    }
} else {
    echo "Produto não encontrado.";
}

$conn->close();
?>
