<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .card {
            width: 100%;
            max-width: 700px; /* Limiter la largeur maximale */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background: #2575fc;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: #6a11cb;
        }
        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
        }
        .form-label {
            font-weight: bold;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3 class="text-center mb-4">Creer un Compte</h3>

        <!-- Afficher les messages d'alerte -->
        <?php
        if (isset($_SESSION['message'])) {
            $message_type = $_SESSION['message_type'] ?? 'info';
            echo "<div class='alert alert-$message_type' role='alert'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']); // Supprimer le message après affichage
        }
        ?>

        <form method="POST" action="register.php">
            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez votre nom" required>
            </div>
            <!-- Prénom -->
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Entrez votre prénom" required>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre e-mail" required>
            </div>
            <!-- Mot de passe -->
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" placeholder="Créez un mot de passe" required>
            </div>
            <!-- Confirmez le mot de passe -->
            <div class="mb-3">
                <label for="confirme_mot_de_passe" class="form-label">Confirmez le mot de passe</label>
                <input type="password" name="confirme_mot_de_passe" id="confirme_mot_de_passe" class="form-control" placeholder="Confirmez votre mot de passe" required>
            </div>
            <!-- Bouton -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
        </form>
        <p class="text-center mt-3">
            Déjà inscrit ? <a href="login.php" class="text-decoration-none">Connectez-vous</a>
        </p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
