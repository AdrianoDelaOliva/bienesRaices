<?php
function conectarDB(): PDO
{
    $env = parse_ini_file(__DIR__ . '/../../.env.local');

    $url = $env['DATABASE_URL'] ?? null;

    if (!$url) {
        throw new RuntimeException('DATABASE_URL no configurada');
    }

    $config = parse_url($url);

    $host = $config['host'];
    $port = $config['port'] ?? 5432;
    $dbname = ltrim($config['path'], '/');
    $user = rawurldecode($config['user']);
    $password = rawurldecode($config['pass']);

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return $db;
}
