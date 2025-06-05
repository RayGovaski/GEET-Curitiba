<?php
// config.php - Configuração do banco de dados

// Configurações para ambiente local
$local_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'geet'
];

// Configurações para Vercel (usando variáveis de ambiente)
$vercel_config = [
    'host' => $_ENV['DB_HOST'] ?? '',
    'username' => $_ENV['DB_USER'] ?? '',
    'password' => $_ENV['DB_PASS'] ?? '',
    'database' => $_ENV['DB_NAME'] ?? ''
];

// Detectar se está no Vercel
$is_vercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']);

// Usar configuração apropriada
$config = $is_vercel ? $vercel_config : $local_config;

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Em produção, não mostrar detalhes do erro
    if ($is_vercel) {
        die("Erro de conexão com o banco de dados.");
    } else {
        die("Erro de conexão: " . $e->getMessage());
    }
}
?>