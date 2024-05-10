<?php
session_start();

// Controlla se è stata scelta una lingua diversa
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
    // Utilizza la lingua dalla sessione
    $lang = $_SESSION['lang'];
} else {
    // Lingua predefinita (es. italiano)
    $lang = 'it';
}

// Connessione al database con PDO
try {
    $db_host = 'localhost';
    $db_name = 'multilingual';
    $db_user = 'root';
    $db_pass = '';
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // Setta l'attributo per il report degli errori
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
}

// Funzione per ottenere la traduzione
function translate($conn, $lang, $key) {
    $query = "SELECT translation FROM translations WHERE lang=:lang AND `key`=:key";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':lang', $lang);
    $stmt->bindParam(':key', $key);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return $row['translation'];
    } else {
        // Se la traduzione non è disponibile, restituisci la chiave
        return $key;
    }
}

// Recupera le notizie dalla tabella "news"
$query_news = "SELECT * FROM news";
$stmt_news = $conn->query($query_news);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate($conn, $lang, 'welcome'); ?></title>
</head>
<body>
    <h1><?php echo translate($conn, $lang, 'welcome'); ?></h1>
    
    <p><?php echo translate($conn, $lang, 'news_title'); ?></p>
    
    <ul>
        <?php foreach ($stmt_news as $row) : ?>
            <li><?php echo $row['title']; ?></li>
        <?php endforeach; ?>
    </ul>
    
    <p>
        <a href="?lang=it">Italiano</a> |
        <a href="?lang=en">English</a>
    </p>
</body>
</html>