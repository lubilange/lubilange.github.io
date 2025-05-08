<?php
if (!empty($_POST)) {
    // Configuration de la base de données
    $host = 'localhost';
    $dbname = 'school_registration';
    $username = 'root';
    $password = '';

    try {
        // Créer la connexion
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer et nettoyer les données
        $firstName = trim($_POST['firstName'] ?? '');
        $lastName = trim($_POST['lastName'] ?? '');
        $birthdate = trim($_POST['date'] ?? '');
        $nationality = trim($_POST['Nationality'] ?? null);
        $email = filter_var($_POST['E-mail'] ?? null, FILTER_SANITIZE_EMAIL);
        $phoneNumber = trim($_POST['phoneNumber'] ?? null);
        $address = trim($_POST['Address'] ?? null);
        $sexe = $_POST['Sexe'] ?? null;
        $school_id = !empty($_POST['school']) ? (int)$_POST['school'] : null;

        // Valider les données
        $isValid = true;

        // Validation du prénom
        if (empty($firstName)) {
            $response['errors']['firstName'] = "Le prénom est obligatoire";
            $isValid = false;
        } elseif (strlen($firstName) > 100) {
            $response['errors']['firstName'] = "Le prénom est trop long (100 caractères maximum)";
            $isValid = false;
        }

        // Validation du nom
        if (empty($lastName)) {
            $response['errors']['lastName'] = "Le nom est obligatoire";
            $isValid = false;
        } elseif (strlen($lastName) > 100) {
            $response['errors']['lastName'] = "Le nom est trop long (100 caractères maximum)";
            $isValid = false;
        }

        // Validation de la date de naissance
        if (empty($birthdate)) {
            $response['errors']['birthdate'] = "La date de naissance est obligatoire";
            $isValid = false;
        } else {
            $dateObj = DateTime::createFromFormat('Y-m-d', $birthdate);
            if (!$dateObj || $dateObj->format('Y-m-d') !== $birthdate) {
                $response['errors']['birthdate'] = "Format de date invalide (YYYY-MM-DD requis)";
                $isValid = false;
            }
        }

        // Validation de l'email si fourni
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = "Format d'email invalide";
            $isValid = false;
        }

        // Validation du numéro de téléphone si fourni
        if ($phoneNumber && !preg_match('/^[0-9]{10,20}$/', $phoneNumber)) {
            $response['errors']['phoneNumber'] = "Numéro de téléphone invalide (10-20 chiffres)";
            $isValid = false;
        }

        // Si validation réussie
        if ($isValid) {
            // Préparation de la requête SQL
            $sql = "INSERT INTO students 
                    (firstName, lastName, birthdate, nationality, email, phoneNumber, address, sexe, school_id) 
                    VALUES 
                    (:firstName, :lastName, :birthdate, :nationality, :email, :phoneNumber, :address, :sexe, :school_id)";

            $stmt = $conn->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':nationality', $nationality);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':sexe', $sexe);
            $stmt->bindParam(':school_id', $school_id, PDO::PARAM_INT);

            // Exécution
            $stmt->execute();

            // Mise à jour de la réponse
            $response = [
                'success' => true,
                'message' => 'Étudiant enregistré avec succès',
                'student_id' => $conn->lastInsertId()
            ];
        } else {
            $response['message'] = "Erreurs de validation";
        }
    } catch (PDOException $e) {
        $response['message'] = "Erreur de base de données: " . $e->getMessage();
        error_log("Database error: " . $e->getMessage());
    } catch (Exception $e) {
        $response['message'] = "Erreur: " . $e->getMessage();
        error_log("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription des étudiants</title>
    <link rel="stylesheet" href="/static/styles/style.css">
</head>

<body id="formular">
    <header>
        <div class="logo"><span class="blue">Peda</span><span class="orange">goo</span> - École</div>

    </header>
    <div class="container">
        <h1 class="stu">Inscription des étudiants</h1>
        <form id="citizenForm" action="" method="POST">
            <label class="titres">À propos de l'étudiant</label>
            <label for="firstName">Prénom :</label>
            <input type="text" id="firstName" name="firstName" placeholder="Entrez votre prénom">
            <br>
            <label for="lastName">Nom :</label>
            <input type="text" id="lastName" name="lastName" placeholder="Entrez votre nom">
            <br>
            <label for="date">Date de naissance:</label>
            <input type="date" id="date" name="date" required>
            <br>
            <label for="Nationality">Nationalité :</label>
            <select id="pays" name="Nationality"></select>
            <br>
            <label for="E-mail">E-mail :</label>
            <input type="email" id="E-mail" name="E-mail" placeholder="Entrez votre e-mail" size="50" maxlength="50">
            <br>
            <label for="phoneNumber">Numéro de téléphone :</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Entrez votre numéro de téléphone" size="10" maxlength="10">
            <br>
            <label for="Address">Adresse :</label>
            <input type="text" id="Address" name="Address" placeholder="Pays/Ville/Quartier/Avenue N" size="80" maxlength="80">
            <br>
            <label for="Sexe">Sexe :</label>
            <select id="Sexe" name="Sexe" aria-multiselectable="true">
                <option>Homme</option>
                <option>Femme</option>
            </select>
            <br>
            <label class="titres">À propos des responsables</label>
            <label class="soustitres">Père</label>
            <label for="ffirstName">Prénom :</label>
            <input type="text" id="ffirstName" name="ffirstName" placeholder="Entrez le prénom du père">
            <br>
            <label for="fname">Nom :</label>
            <input type="text" id="fname" name="fname" placeholder="Entrez le nom du père">
            <br>
            <label for="fphoneNumber">Numéro de téléphone :</label>
            <input type="tel" id="fphoneNumber" name="fphoneNumber" placeholder="Entrez le numéro de téléphone du père" size="12" maxlength="12">
            <br>
            <label for="fE-mail">E-mail :</label>
            <input type="email" id="fE-mail" name="fE-mail" placeholder="Entrez l'e-mail du père" size="50" maxlength="50">
            <br>
            <label for="fprofession">Profession :</label>
            <input type="text" id="fprofession" name="fprofession" placeholder="Entrez la profession du père">
            <br>
            <label class="soustitres">Mère</label>
            <label for="mfirstName">Prénom :</label>
            <input type="text" id="mfirstName" name="mfirstName" placeholder="Entrez le prénom de la mère">
            <br>
            <label for="mname">Nom :</label>
            <input type="text" id="mname" name="mname" placeholder="Entrez le nom de la mère">
            <br>
            <label for="mphoneNumber">Numéro de téléphone :</label>
            <input type="tel" id="mphoneNumber" name="mphoneNumber" placeholder="Entrez le numéro de téléphone de la mère" size="12" maxlength="12">
            <br>
            <label for="mE-mail">E-mail :</label>
            <input type="email" id="mE-mail" name="mE-mail" placeholder="Entrez l'e-mail de la mère" size="50" maxlength="50">
            <br>
            <label for="mprofession">Profession :</label>
            <input type="text" id="mprofession" name="mprofession" placeholder="Entrez la profession de la mère">
            <br>
            <label class="soustitres">Responsable en cas d'urgence</label>
            <label for="ofirstName">Prénom :</label>
            <input type="text" id="ofirstName" name="ofirstName" placeholder="Entrez le prénom de l'urgence">
            <br>
            <label for="oname">Nom :</label>
            <input type="text" id="oname" name="oname" placeholder="Entrez le nom de l'urgence">
            <br>
            <label for="ophoneNumber">Numéro de téléphone :</label>
            <input type="tel" id="ophoneNumber" name="ophoneNumber" placeholder="Entrez le numéro de téléphone d'urgence" size="12" maxlength="12">
            <br>
            <label for="oE-mail">E-mail :</label>
            <input type="email" id="oE-mail" name="oE-mail" placeholder="Entrez l'e-mail d'urgence" size="50" maxlength="50">
            <br>
            <label for="oprofession">Profession :</label>
            <input type="text" id="oprofession" name="oprofession" placeholder="Entrez la profession d'urgence">
            <br>
            <label class="titres">À propos du parcours scolaire</label>
            <label for="school">École :</label>
            <input type="text" id="school" name="school" placeholder="Entrez l'école">
            <br>
            <label for="sproof">Preuve de réussite :</label>
            <select id="Sproof" name="sproof">
                <option>Diplôme d'État</option>
                <option>Attestation de réussite</option>
            </select>
            <br>
            <label for="dep">Département :</label>
            <input type="text" id="dep" name="dep" placeholder="Entrez le département">
            <br>
            <label for="year">Année :</label>
            <select id="year" name="year">
                <option>2024</option>
                <option>2023</option>
                <option>2022</option>
                <option>2021</option>
                <option>2020</option>
                <option>2019</option>
            </select>
            <br>
            <label class="titres">À propos de votre choix</label>
            <label class="soustitres">Département</label>
            <label for="Faculty1">Premier choix :</label>
            <select id="Faculty1" name="Faculty1">
                <option>Sciences fondamentales</option>
                <option>Sciences économiques et de gestion</option>
                <option>Informatique</option>
                <option>Sciences de l'information et de la communication</option>
                <option>Sciences technologiques</option>
                <option>Environnement</option>
                <option>Architecture</option>
            </select>
            <br>
            <label for="Faculty2">Deuxième choix :</label>
            <select id="Faculty2" name="Faculty2">
                <option>Sciences fondamentales</option>
                <option>Sciences économiques et de gestion</option>
                <option>Informatique</option>
                <option>Sciences de l'information et de la communication</option>
                <option>Sciences technologiques</option>
                <option>Environnement</option>
                <option>Architecture</option>
            </select>
            <br>
            <button type="submit" class="submit">Soumettre le formulaire</button>
            <button type="button" class="reset">Réinitialiser</button>
        </form>
    </div>

    <div class="snackbar" id="snackbar">Formulaire soumis avec succès</div>
    <script src="student.js"></script>
</body>

</html>