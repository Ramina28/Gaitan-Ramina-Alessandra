<?php
// AFIȘARE ERORI - DOAR PENTRU DEZVOLTARE
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Conectare la baza de date
$host   = "mysql";        // numele serviciului din docker-compose
$dbname = "studenti";     // SAU Gaitan_Ramina, vezi mai jos
$user   = "user";
$pass   = "password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Eroare conectare la baza de date: " . $e->getMessage());
}

// 2. Funcție care afișează abonamentele pentru un joc
function afiseazaAbonamente(PDO $pdo, string $joc): void {
    try {
        $stmt = $pdo->prepare("SELECT durata, pret FROM abonamente WHERE joc = ? ORDER BY id ASC");
        $stmt->execute([$joc]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            echo "<tr><td colspan='2'>Nu există abonamente pentru acest joc.</td></tr>";
            return;
        }

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['durata']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pret']) . " RON</td>";
            echo "</tr>";
        }
    } catch (PDOException $e) {
        echo "<tr><td colspan='2'>Eroare: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonamente Centrul de Agrement</title>
    <link rel="stylesheet" href="abonamente.css">
</head>

<button id="btnTop" title="Înapoi sus">↑</button>

<body>

<a href="Pagina principala.html" class="buton-inapoi">←</a>

<header>
    <h1>Abonamente Centrul de Agrement</h1>
</header>

<div class="container">
    <h2>Biliard</h2>
    <table>
        <tr>
            <th>Durată</th>
            <th>Preț</th>
        </tr>
        <?php afiseazaAbonamente($pdo, "Biliard"); ?>
    </table>

    <h2>Bowling</h2>
    <table>
        <tr>
            <th>Durată</th>
            <th>Preț</th>
        </tr>
        <?php afiseazaAbonamente($pdo, "Bowling"); ?>
    </table>

    <h2>Minigolf</h2>
    <table>
        <tr>
            <th>Durată</th>
            <th>Preț</th>
        </tr>
        <?php afiseazaAbonamente($pdo, "Minigolf"); ?>
    </table>

    <h2>Cățărare</h2>
    <table>
        <tr>
            <th>Durată</th>
            <th>Preț</th>
        </tr>
        <?php afiseazaAbonamente($pdo, "Cățărare"); ?>
    </table>

    <h2>Ping Pong</h2>
    <table>
        <tr>
            <th>Durată</th>
            <th>Preț</th>
        </tr>
        <?php afiseazaAbonamente($pdo, "Ping Pong"); ?>
    </table>
</div>

<script src="main.js"></script>
</body>
</html>
