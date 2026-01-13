<?php
header("Content-Type: application/json; charset=UTF-8");

$host = "mysql";
$db = "studenti";
$user = "user";
$pass = "password";
try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8mb4",
    $user,
    $pass,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => "Eroare DB"]);
  exit;
}

/* ================= GET ================= */
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $stmt = $pdo->query("SELECT id, nume, an, media, creat_la FROM studenti ORDER BY id DESC");
  echo json_encode($stmt->fetchAll());
  exit;
}

/* ================= POST ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $input = json_decode(file_get_contents("php://input"), true) ?? $_POST;

  $nume  = trim($input["nume"] ?? "");
  $an    = (int)($input["an"] ?? 0);
  $media = (float)($input["media"] ?? 0);

  if ($nume === "" || $an < 1 || $an > 4 || $media < 1 || $media > 10) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Date invalide"]);
    exit;
  }

  $stmt = $pdo->prepare("INSERT INTO studenti (nume, an, media) VALUES (?, ?, ?)");
  $stmt->execute([$nume, $an, $media]);

  $id = $pdo->lastInsertId();
  $stmt = $pdo->prepare("SELECT id, nume, an, media, creat_la FROM studenti WHERE id = ?");
  $stmt->execute([$id]);

  echo json_encode(["success" => true, "student" => $stmt->fetch()]);
  exit;
}

http_response_code(405);
echo json_encode(["success" => false, "error" => "Metodă nepermisă"]);
