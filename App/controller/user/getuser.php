<?php
try {
    // Configuration de la base de données
    $host = "localhost"; // Hôte (par défaut pour XAMPP est localhost)
    $dbName = "purebuzz"; // Remplacez par le nom de votre base de données
    $username = "root"; // Nom d'utilisateur MySQL par défaut pour XAMPP
    $passwordDB = ""; // Mot de passe MySQL par défaut pour XAMPP est vide

    // Connexion à la base de données avec PDO
    $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $passwordDB);

    // Définir le mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL pour récupérer les utilisateurs
    $stmt = $pdo->prepare(
        "SELECT id, first_name, last_name, email, role ,date_of_birth
         FROM users"
    );

    // Exécuter la requête
    $stmt->execute();

    // Récupérer tous les utilisateurs sous forme de tableau associatif
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envoyer les données en JSON
    header('Content-Type: application/json');
    echo json_encode($users);

} catch (PDOException $e) {
    // Gérer les exceptions PDO
    header('Content-Type: application/json');
    echo json_encode(["error" => "Erreur de connexion à la base de données : " . $e->getMessage()]);
}
?>
