<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuration de la base de données
$host = '127.0.0.1';
$db = 'geotracer';
$user = 'root';
$pass = 'root';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérification de l'existence de l'email dans la base de données
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        echo 'Cet email est déjà utilisé.';
        exit;
    }

    // Insertion des données dans la base de données avec une gestion sécurisée du mot de passe
    $stmt = $conn->prepare("INSERT INTO users (email, pseudo, name, username, password, is_verified) 
                            VALUES (:email, :pseudo, :name, :username, :password, 0)");
    $stmt->execute([
        'email' => $email,
        'pseudo' => $nom,
        'name' => $nom,
        'username' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    // Redirection vers la page d'accueil après une inscription réussie
    header('Location: /GEO_TRACER-MAIN/html/acceuil.html');
    exit;
}
?>