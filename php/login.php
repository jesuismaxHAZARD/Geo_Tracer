<?php
session_start();

// Activer l'affichage des erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Définir les en-têtes pour une réponse JSON
header("Content-Type: application/json");

// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Identifiant root
$password = "root"; // Mot de passe root
$dbname = "geotracer"; // Nom de la base de données corrigé

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erreur de connexion à la base de données"]);
    exit();
}

// Vérifier si la requête est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier que les champs ne sont pas vides
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        echo json_encode(["success" => false, "message" => "Veuillez remplir tous les champs"]);
        exit();
    }

    // Nettoyer les entrées utilisateur
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT id_users, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($password, $user["password"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id_users"] = $user["id_users"];
            $_SESSION["email"] = $user["email"];

            echo json_encode(["success" => true, "message" => "Connexion réussie"]);
        } else {
            echo json_encode(["success" => false, "message" => "Mot de passe incorrect"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Adresse e-mail introuvable"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}

$conn->close();
?>