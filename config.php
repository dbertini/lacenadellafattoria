<?php
// config.php - Configurazione del database e funzioni comuni

// Configurazione database
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_lacenadellafattoria');
define('DB_USER', 'lacenadellafattoria');  // Modifica con il tuo username

// Connessione al database
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Errore di connessione al database: " . $e->getMessage());
    }
}

// Funzione per sanitizzare input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Funzione per verificare se un utente ha già votato
function hasUserVoted($pdo, $sondaggio_id, $nome, $email = null) {
    $sql = "SELECT COUNT(*) FROM voti WHERE sondaggio_id = ? AND nome_votante = ?";
    $params = [$sondaggio_id, $nome];
    
    if ($email) {
        $sql .= " AND email_votante = ?";
        $params[] = $email;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn() > 0;
}

// Funzione per ottenere l'IP del client
function getClientIP() {
    $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) && !empty($_SERVER[$key])) {
            $ip = explode(',', $_SERVER[$key]);
            return trim($ip[0]);
        }
    }
    return 'unknown';
}

// Funzione per formattare la data in italiano
function formatDate($date) {
    $mesi = [
        1 => 'gennaio', 2 => 'febbraio', 3 => 'marzo', 4 => 'aprile',
        5 => 'maggio', 6 => 'giugno', 7 => 'luglio', 8 => 'agosto',
        9 => 'settembre', 10 => 'ottobre', 11 => 'novembre', 12 => 'dicembre'
    ];
    
    $timestamp = strtotime($date);
    $giorno = date('d', $timestamp);
    $mese = $mesi[(int)date('n', $timestamp)];
    $anno = date('Y', $timestamp);
    $ora = date('H:i', $timestamp);
    
    return "$giorno $mese $anno alle $ora";
}

// Funzione per verificare se un sondaggio è ancora attivo
function isSondaggioAttivo($sondaggio) {
    if (!$sondaggio['attivo']) {
        return false;
    }
    
    if ($sondaggio['data_scadenza'] && strtotime($sondaggio['data_scadenza']) < time()) {
        return false;
    }
    
    return true;
}
?>