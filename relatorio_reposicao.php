<?php
// Inclui o arquivo de conexao com o banco de dados
include 'conexao.php';

// Cabecalho para download do arquivo XML
header('Content-Type: text/xml');
header('Content-Disposition: attachment; filename="relatorio_reposicao.xml"');

// Inicia o XML
$xml = new SimpleXMLElement('<reposicao/>');

// Consulta SQL para calcular o relatorio
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
    p.nome_produto, p.qtde_estoque;
";

$resultado = mysqli_query($conexao, $sql);

// Verifica se ha resultados
if (mysqli_num_rows($resultado) > 0) {
    while ($linha = mysqli_fetch_assoc($resultado)) {
        // Cria um no para cada produto
        $produto = $xml->addChild('produto');
        $produto->addChild('produto', $linha['nome_produto']);
        $produto->addChild('estoque_atual', $linha['qtde_estoque']);
        $produto->addChild('venda_mensal', $linha['media_vend_mensal']);
        $produto->addChild('repor', $linha['qtde_arepor']);
    }
} else {
    // Adiciona uma mensagem se nao houver resultados
    $xml->addChild('mensagem', 'Nenhum dado encontrado para os últimos 3 meses.');
}

// Exibe o XML
echo $xml->asXML();

// Fecha a conexao com o banco
mysqli_close($conexao);
?>
