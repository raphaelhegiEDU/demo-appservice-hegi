<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resource Group</title>
</head>
<body>
    <h1>Create a New Resource Group</h1>
    <form method="post" action="newrg.php">
        <label for="name">Resource Group Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="location">Location:</label><br>
        <select id="location" name="location" required>
            <option value="switzerlandnorth">Switzerland North</option>
            <option value="northeurope">North Europe</option>
        </select><br><br>

        <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $location = $_POST['location'];

        // JSON-Daten vorbereiten
        $data = [
            'name' => $name,
            'location' => $location
        ];

        // JSON in einen String umwandeln
        $jsonData = json_encode($data);

        // URL der API aus der Umgebungsvariable abrufen
        $url = getenv('CREATE_RESOURCE_GROUP_API_URL');

        if (!$url) {
            echo "<p style='color: red;'>Die Umgebungsvariable CREATE_RESOURCE_GROUP_API_URL ist nicht gesetzt.</p>";
            exit;
        }

        // cURL verwenden, um die POST-Anfrage zu senden
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Antwort der API abrufen
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Antwort anzeigen
        if ($httpStatus === 200) {
            echo "<p style='color: green;'>Resource Group created successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to create Resource Group. Status Code: $httpStatus</p>";
        }
        echo "<p>Response: $response</p>";
    }
    ?>
</body>
</html>