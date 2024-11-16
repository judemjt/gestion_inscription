<?php
include 'includes/db.php'; // Inclure la connexion à la base de données

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirme_mot_de_passe = $_POST['confirme_mot_de_passe'];

    // Vérifier si les mots de passe correspondent
    if ($mot_de_passe !== $confirme_mot_de_passe) {
        $_SESSION['message'] = 'Les mots de passe ne correspondent pas.';
        $_SESSION['message_type'] = 'danger';  // Utilisation de "danger" pour erreur
    } else {
        // Vérifier si l'email existe déjà dans la base de données
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur) {
            // Si l'utilisateur existe déjà, afficher un message d'erreur
            $_SESSION['message'] = 'Cet e-mail est déjà utilisé.';
            $_SESSION['message_type'] = 'danger';
        } else {
            // Insérer le nouvel utilisateur dans la base de données
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $email, $hashed_password]);

            // Afficher un message de succès
            $_SESSION['message'] = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
            $_SESSION['message_type'] = 'success';
        }
    }

    // Rediriger vers la page d'inscription pour afficher le message
    header('Location: inscription.php');
    exit;
}
?>
