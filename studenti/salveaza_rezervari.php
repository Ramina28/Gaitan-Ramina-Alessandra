<?php
// ================================
// 1. Conectare la baza de date
// ================================
$host = "mysql";        // numele serviciului din docker-compose.yml
$dbname = "studenti";   // baza ta de date
$user = "user";         // MYSQL_USER (din docker-compose)
$pass = "password";     // MYSQL_PASSWORD (din docker-compose)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Eroare conectare la baza de date: " . $e->getMessage());
}



// ================================
// 2. Procesare formular
// ================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Luăm datele din formular
    $nume    = trim($_POST["nume"]);
    $email   = trim($_POST["email"]);
    $telefon = trim($_POST["telefon"]);
    $joc     = trim($_POST["joc"]);
    $data    = trim($_POST["data"]);
    $ora     = trim($_POST["ora"]);

    // ================================
    // 3. Inserăm utilizatorul
    // ================================
    $stmt = $pdo->prepare("INSERT INTO utilizatori (nume, email, telefon)
                           VALUES (?, ?, ?)");
    $stmt->execute([$nume, $email, $telefon]);

    // Obținem id-ul utilizatorului inserat
    $id_utilizator = $pdo->lastInsertId();

    // ================================
    // 4. Inserăm rezervarea
    // ================================
    $stmt = $pdo->prepare("INSERT INTO rezervari (id_utilizator, joc, data_rezervare, ora)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_utilizator, $joc, $data, $ora]);

    // ================================
    // 5. Mesaj final
    // ================================
    echo "<script>alert('Rezervarea a fost salvată cu succes!'); window.location.href='rezervari.html';</script>";
    exit;
} else {
    echo "Acces invalid.";
}
?>
