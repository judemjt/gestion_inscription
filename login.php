<?php
include 'includes/db.php';
include 'includes/header.php';
require_once 'vendor/autoload.php'; // Assurez-vous que le chemin d'accès à autoload.php est correct

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configuration de Google Client
$client = new Google_Client();
$client->setClientId('55042440082-7344ggqroebfh242vf8umnd5nmdulvas.apps.googleusercontent.com'); // Remplacez par votre client ID
$client->setClientSecret('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'); // Remplacez par votre client secret
$client->setRedirectUri('http://localhost/gestion/login.php'); // Remplacez par l'URL de redirection
$client->addScope('email');
$client->addScope('profile'); // Ajoutez l'accès au profil pour récupérer le nom, prénom, et photo

// Si l'utilisateur est déjà connecté via Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    header('Location: ' . filter_var($client->getRedirectUri(), FILTER_SANITIZE_URL));
}

// Si l'utilisateur est authentifié, obtenir les informations de l'utilisateur
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    $google_oauth = new Google_Service_Oauth2($client);
    $google_user_info = $google_oauth->userinfo->get();
    
    // Récupérer les informations utilisateur
    $google_email = $google_user_info->email;
    $google_first_name = $google_user_info->givenName; // Prénom
    $google_last_name = $google_user_info->familyName; // Nom
    $google_id = $google_user_info->id;
    $google_profile_picture = $google_user_info->picture; // Photo de profil
    
    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$google_email]);
    $utilisateur = $stmt->fetch();

    // Si l'utilisateur n'existe pas, créez-le
    if (!$utilisateur) {
        $sql = "INSERT INTO utilisateurs (email, mot_de_passe, prenom, nom, login_via_google, profile_picture) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$google_email, '', $google_first_name, $google_last_name, 1, $google_profile_picture]);
        $utilisateur = $pdo->lastInsertId(); // Récupérer l'ID de l'utilisateur nouvellement créé
    }
    
    // Authentifier l'utilisateur dans votre session
    $_SESSION['user_id'] = $utilisateur['id'];
    header('Location: dashboard.php');
    exit;
}

// Si l'utilisateur n'est pas connecté via Google, afficher le bouton de connexion
$login_url = $client->createAuthUrl();
?>

<div class="container mt-5">
    <h2 class="text-center">Connexion</h2>
    <form method="POST" action="" class="w-50 mx-auto mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre email" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
    <p class="text-center mt-3">
        Vous n'avez pas de compte ? <a href="inscription.php" class="text-decoration-none">Créez-en un ici</a>.
    </p>
    
    <div class="text-center mt-4">
        <a href="<?= $login_url ?>" class="btn btn-danger w-100">Se connecter avec Google</a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
