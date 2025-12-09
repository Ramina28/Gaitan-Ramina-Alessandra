<?php

$name = $email = $message = "";
$errors = ["name" => "", "email" => "", "message" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validare PHP
    if (strlen($name) < 3) {
        $errors["name"] = "Numele trebuie să aibă minim 3 caractere.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Introduceți o adresă de email validă.";
    }

    if (strlen($message) < 10) {
        $errors["message"] = "Mesajul trebuie să conțină minim 10 caractere.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Formular Contact</title>

    <style>
        body { font-family: Arial, sans-serif; width: 500px; margin: 40px auto; }
        form { display: flex; flex-direction: column; gap: 10px; }
        input, textarea { width: 100%; padding: 8px; font-size: 15px; }
        .error { color: red; font-size: 14px; }
        #success { color: green; font-size: 18px; margin-top: 20px; font-weight: bold; }
    </style>
</head>

<body>

<h2>Formular de Contact</h2>

<form id="contactForm" method="POST">
    <label>Nume:</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>">
    <div class="error"><?= $errors["name"] ?></div>

    <label>Email:</label>
    <input type="text" name="email" id="email" value="<?= htmlspecialchars($email) ?>">
    <div class="error"><?= $errors["email"] ?></div>

    <label>Mesaj:</label>
    <textarea name="message" id="message"><?= htmlspecialchars($message) ?></textarea>
    <div class="error"><?= $errors["message"] ?></div>

    <button type="submit">Trimite</button>
</form>

<div id="success"></div>

<script>
// Validare JavaScript + mesaj de mulțumire
document.getElementById("contactForm").addEventListener("submit", function(event) {

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();
    let successDiv = document.getElementById("success");

    // Preluăm erorile generate de PHP
    let hasErrors = document.querySelectorAll(".error")
        |> Array.from
        |> (arr => arr.some(e => e.textContent !== ""));

    if (!hasErrors) {
        event.preventDefault(); // Oprim trimiterea formularului

        successDiv.innerHTML =
            "Mulțumim, <b>" + name +
            "</b>! Mesajul tău a fost primit:<br><br>„" +
            message + "”";

        // Resetăm formularul
        document.getElementById("contactForm").reset();
    }
});
</script>

</body>
</html>
