<?php
// Dados de conexao
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'controle_estoque';
$porta = 3307; // Porta do seu MySQL

// Criar conexao
$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

// Verificar conexao
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}
?>
