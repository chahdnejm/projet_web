<?php
// Inclure PHPMailer via Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connexion à la base de données
$host = 'localhost';
$dbName = 'purebuzz';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;

    if (!$email) {
        echo json_encode(["success" => false, "message" => "Email is required."]);
        exit;
    }

    // Vérifier si l'email existe dans la base de données
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        // Générer un token unique pour la réinitialisation
        $token = bin2hex(random_bytes(16));

        // Enregistrer le token dans la base de données
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, created_at) VALUES (:user_id, :token, NOW())");
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Utiliser PHPMailer pour envoyer l'email de réinitialisation
        $mail = new PHPMailer(true);

        try {
            // Configurer le serveur SMTP de Mailtrap
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_mailtrap_username'; // Remplacez par votre nom d'utilisateur Mailtrap
            $mail->Password = 'your_mailtrap_password'; // Remplacez par votre mot de passe Mailtrap
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Déboguer pour obtenir plus d'infos
            $mail->SMTPDebug = PHPMailer::DEBUG_SERVER;
            $mail->Debugoutput = 'html'; // Affiche les logs

            // Destinataire
            $mail->setFrom('no-reply@yourwebsite.com', 'Support');
            $mail->addAddress($email); // L'email de l'utilisateur

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'Click the link to reset your password: <a href="http://yourwebsite.com/resetPasswordForm.php?token=' . $token . '">Reset Password</a>';

            // Envoi de l'email
            $mail->send();
            echo json_encode(["success" => true, "message" => "Password reset link sent."]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "message" => "Mailer Error: " . $mail->ErrorInfo . " | Exception: " . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
