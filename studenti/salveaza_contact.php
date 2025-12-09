<?php
// ================================
// 1. Conectare la baza de date
// ================================
$host = "mysql";        // numele serviciului din docker-compose.yml
$dbname = "studenti";   // schimba dacă BD ta are alt nume (ex: Gaitan_Ramina)
$user = "user";         // MYSQL_USER
$pass = "password";     // MYSQL_PASSWORD

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Eroare conectare: " . $e->getMessage());
}


// ================================
// 2. Procesare formular
// ================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Luăm datele din formular
    $nume    = trim($_POST["nume"]);
    $email   = trim($_POST["email"]);
    $telefon = trim($_POST["telefon"]);
    $mesaj   = trim($_POST["mesaj"]);

    // ================================
    // 3. Salvăm mesajul în tabelul contact
    // ================================
    $stmt = $pdo->prepare("INSERT INTO contact (nume_complet, email, telefon, mesaj)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$nume, $email, $telefon, $mesaj]);

    // ================================
    // 4. Răspuns pentru utilizator
    // ================================
    echo "<script>alert('Mesaj trimis cu succes!'); window.location.href='contact.html';</script>";
    exit;

} else {
    echo "Acces invalid.";
}
?>
