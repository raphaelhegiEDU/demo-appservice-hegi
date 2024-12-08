<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Groups</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Resource Groups</h1>
    
    <?php
    // URL aus der Umgebungsvariable abrufen
    $url = getenv('RESOURCE_GROUP_API_URL');

    if (!$url) {
        echo '<p style="color: red;">Die Umgebungsvariable RESOURCE_GROUP_API_URL ist nicht gesetzt.</p>';
        exit;
    }

    // JSON-Daten abrufen
    $json = @file_get_contents($url);

    // Überprüfen, ob die JSON-Daten erfolgreich abgerufen wurden
    if ($json === FALSE) {
        echo '<p style="color: red;">Die JSON-Daten konnten nicht von der URL ' . htmlspecialchars($url) . ' geladen werden.</p>';
        exit;
    }

    // JSON in ein PHP-Array umwandeln
    $data = json_decode($json, true);

    // Überprüfen, ob die Daten erfolgreich geladen wurden
    if ($data && is_array($data)) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Resource Group Name</th>';
        echo '<th>Location</th>';
        echo '<th>Resource ID</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Daten in die Tabelle einfügen
        foreach ($data as $item) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item['ResourceGroupName']) . '</td>';
            echo '<td>' . htmlspecialchars($item['Location']) . '</td>';
            echo '<td>' . htmlspecialchars($item['ResourceId']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Die JSON-Daten konnten nicht verarbeitet werden.</p>';
    }
    ?>

    <p><a href="newrg.php">Neue Resource Group anlegen</a></p>

</body>
</html>