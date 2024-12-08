<?php
// Connection String aus der Umgebungsvariable abrufen
$connectionString = getenv('MYSQL_CONNECTION_STRING');

// Connection String parsen
$parts = parse_url($connectionString);
$host = $parts['host'];
$dbname = ltrim($parts['path'], '/');
$username = $parts['user'];
$password = $parts['pass'];

// DSN erstellen
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Überprüfen, ob die Umgebungsvariable gesetzt ist
 if (!$connectionString) {
    die("Die Umgebungsvariable 'MYSQL_CONNECTION_STRING' ist nicht gesetzt.");
}

try {
    // PDO-Verbindung herstellen
    $pdo = new PDO($dsn, $username, $password);   
  
    // Fehlerbehandlung aktivieren
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Daten abrufen
    $stmt = $pdo->query("SELECT * FROM users");

    // HTML-Ausgabe
    echo "<h1>User List</h1>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
