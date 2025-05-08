<?php
if (!empty($_POST)) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=school_registration', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        // Dossier où seront stockées les images
        $uploadDir = __DIR__ . '/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Traitement de l'upload des images
        $ecoleImagePath = null;
        $logoImagePath = null;

        // Traitement de l'image de l'école (bannière)
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $bannerName = uniqid() . '_' . basename($_FILES['banner']['name']);
            $bannerTarget = $uploadDir . $bannerName;
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $bannerTarget)) {
                $ecoleImagePath = 'uploads/' . $bannerName;
            }
        }

        // Traitement du logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoName = uniqid() . '_' . basename($_FILES['logo']['name']);
            $logoTarget = $uploadDir . $logoName;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoTarget)) {
                $logoImagePath = 'uploads/' . $logoName;
            }
        }

        // Récupération des valeurs du formulaire
        $name = $_POST['Name'] ?? '';
        $address = $_POST['Address'] ?? '';
        $descript = $_POST['Descript'] ?? '';
        $devise = $_POST['devise'] ?? '';
        $section = $_POST['section'] ?? '';
        $email = $_POST['Email'] ?? '';
        $phoneNumber = $_POST['phoneNumber'] ?? '';
        $siteweb = $_POST['siteweb'] ?? '';
        $teacherCount = $_POST['teacherCount'] ?? null;

        // Requête SQL corrigée avec les bons noms de colonnes
        $db = $pdo->prepare("INSERT INTO schools 
            (name, address, description, devise, section, email, phoneNumber, siteweb, EcoleImage, logoImage, teacherCount) 
            VALUES 
            (:name, :address, :descript, :devise, :section, :email, :phoneNumber, :siteweb, :ecoleImage, :logoImage, :teacherCount)");

        // Exécution de la requête avec les valeurs
        $db->execute([
            ':name' => $name,
            ':address' => $address,
            ':descript' => $descript,
            ':devise' => $devise,
            ':section' => $section,
            ':email' => $email,
            ':phoneNumber' => $phoneNumber,
            ':siteweb' => $siteweb,
            ':ecoleImage' => $ecoleImagePath,
            ':logoImage' => $logoImagePath,
            ':teacherCount' => $teacherCount
        ]);

        echo "<div class='success-message'>École enregistrée avec succès !</div>";
    } catch (PDOException $e) {
        echo "<div class='error-message'>Erreur lors de l'enregistrement: " . $e->getMessage() . "</div>";
    } catch (Exception $e) {
        echo "<div class='error-message'>Erreur: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Registration</title>
    <link rel="stylesheet" href="/static/styles/style.css">
    <style>
        .success-message {
            color: green;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid green;
            background-color: #e6ffe6;
        }

        .error-message {
            color: red;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid red;
            background-color: #ffe6e6;
        }
    </style>
</head>

<body id="formular">
    <header>
        <div class="logo"><span class="blue">Peda</span><span class="orange">goo</span> - École</div>

    </header>

    <div class="container">
        <h1 class="stu">School registration</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="Name">Name:</label>
            <input type="text" id="name" name="Name" placeholder="Enter name of the establishment" required>
            <br>
            <label for="Address">Address:</label>
            <input type="text" id="address" name="Address" placeholder="country/city/Quator/Avenu N" size="80" maxlength="80" required>
            <br>
            <label for="Descript">Description:</label>
            <textarea id="descript" name="Descript" placeholder="Enter the description" rows="4" cols="50"></textarea>
            <br>
            <label for="devise">Devise:</label>
            <input type="text" id="dev1" name="devise" placeholder="Enter first devise">
            <br>

            <label for="section">Section:</label>
            <select id="section" name="section" aria-multiselectable="true" required>
                <option value="">-- Select --</option>
                <option value="Maternelle">Maternelle</option>
                <option value="Primaire">Primaire</option>
                <option value="Secondaire">Secondaire</option>
                <option value="Primaire et secondaire">Primaire et secondaire</option>
                <option value="maternelle et primaire">Maternelle et primaire</option>
                <option value="Maternelle, primaire et secondaire">Maternelle, primaire et secondaire</option>
            </select>
            <br>
            <label for="Email">E-mail:</label>
            <input type="email" id="E-mail" name="Email" placeholder="Enter your Email" size="50" maxlength="50">
            <br>
            <label for="phoneNumber">Phone number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="enter your phone number" size="10" maxlength="10">
            <br>
            <label for="siteweb">Website:</label>
            <input type="url" id="siteweb" name="siteweb" placeholder="Enter the link" size="50" maxlength="50">
            <br>
            <label for="teacherCount">Number of teachers:</label>
            <input type="number" id="teacherCount" name="teacherCount" min="0">
            <br>
            <label for="banner">School image:</label>
            <input type="file" id="banner" name="banner" accept="image/*">
            <br>
            <label for="logo">Logo image:</label>
            <input type="file" id="logo" name="logo" accept="image/*">
            <br>

            <button type="submit" id="submitBtn" class="submit">Submit your form</button>
            <br>
        </form>
    </div>
    <div class="toggle-container">
        <label class="switch">
            <input type="checkbox" id="toggleSwitch">
            <span class="slider round"></span>
        </label>
    </div>
    <div class="snackbar" id="snackbar">Form submitted successfully</div>
    <script src="student.js"></script>
</body>

</html>