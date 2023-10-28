<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $data = json_decode(file_get_contents("php://input"), true);
  $base64File = $data["base64File"];

  // Database connection setup (using PDO)
  $host = "localhost:3308";
  $username = "root";
  $password = "";
  $database = "image_file";

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert the base64 file into the database
    $stmt = $pdo->prepare("INSERT INTO files (base64_file) VALUES (:base64File)");
    $stmt->bindParam(":base64File", $base64File, PDO::PARAM_STR);
    $stmt->execute();

    // Respond with success
    echo json_encode(["success" => true]);
  } catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
  }
} else {
  echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
