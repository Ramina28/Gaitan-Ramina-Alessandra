<?php
$name = $email = $message = "";
$errors = ["name" => "", "email" => "", "message" => ""];
$isValid = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if (strlen($name) < 3) {
        $errors["name"] = "Numele trebuie să aibă minim 3 caractere.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Introduceți o adresă de email validă.";
    }

    if (strlen($message) < 10) {
        $errors["message"] = "Mesajul trebuie să conțină minim 10 caractere.";
    }

    if ($errors["name"] === "" && $errors["email"] === "" && $errors["message"] === "") {
        $isValid = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <style>
        body { font-family: Arial; width: 500px; margin: 40px auto; }
        form { display: flex; flex-direction: column; gap: 10px; }
        input, textarea { padding: 8px; width: 100%; font-size: 15px; }
        .error { color: red; font-size: 14px; }
        #success { color: green; font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

<h2>Formular de Contact</h2>

<form id="contactForm" action="" method="POST">
    <label>Nume:</label>
    <input type="text" name="name" id="name"
           value="<?php if (!$isValid) echo htmlspecialchars($name); ?>">
    <div class="error"><?= $errors["name"] ?></div>

    <label>Email:</label>
    <input type="text" name="email" id="email"
           value="<?php if (!$isValid) echo htmlspecialchars($email); ?>">
    <div class="error"><?= $errors["email"] ?></div>

    <label>Mesaj:</label>
    <textarea name="message" id="message"><?php
        if (!$isValid) echo htmlspecialchars($message);
    ?></textarea>
    <div class="error"><?= $errors["message"] ?></div>

    <button type="submit">Trimite</button>
</form>

<div id="success"></div>

<script>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $isValid): ?>
    document.getElementById("success").innerHTML =
        "Mulțumim, <b><?= htmlspecialchars($name) ?></b>!<br>" +
        "Mesajul tău a fost primit:<br><br>„<?= htmlspecialchars($message) ?>”";
<?php endif; ?>
</script>

</body>
</html>
