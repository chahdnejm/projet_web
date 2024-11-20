<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Vérifier que l'identifiant de l'utilisateur est envoyé
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $userId = intval($_POST['id']);

            // Préparer la requête pour supprimer l'utilisateur
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "User deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete user."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "User ID is required."]);
        }
    } catch (PDOException $e) {
        // Gérer les exceptions PDO
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
