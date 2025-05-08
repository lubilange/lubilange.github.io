<?php
$pdo = new PDO('mysql:host=localhost;dbname=school_registration', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
$id = $_GET['id'];
$db = $pdo->prepare("SELECT * FROM schools WHERE id=:id");
$db->execute(['id' => $id]);
$schools = $db->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voir plus - Pedagoo</title>
    <link href="../static/styles/VoirPlus.css" rel="stylesheet" />
</head>

<body>
    <header>
        <div class="logo"><span class="blue">Peda</span><span class="orange">goo</span> - École</div>
        <nav>
            <div class="dropdown" id="dropdown">
                <a href="#" class="dropdown-toggle" id="dropdownToggle">Contactez l'école</a>
                <div class="dropdown-menu" id="dropdownMenu">
                    <?php foreach ($schools as $school): ?>
                        <a href="tel:<?= htmlspecialchars($school['phoneNumber']) ?>">Appeler l'école</a>
                        <a href="https://wa.me/<?= htmlspecialchars($school['phoneNumber']) ?>" target="_blank">WhatsApp</a>
                    <?php endforeach; ?>
                </div>
            </div>
        </nav>

    </header>

    <main class="school-details">
        <?php foreach ($schools as $school): ?>
            <div class="school-card">
                <img
                    src="../<?= htmlspecialchars($school['EcoleImage']) ?>"
                    alt="École"
                    style="width:100%; max-height:400px; object-fit:cover; border-radius:8px; display:block; margin-bottom:20px;" />



                <section class="school-info">
                    <h1><?= htmlspecialchars($school['name']) ?></h1>
                    <p><?= nl2br(htmlspecialchars($school['description'])) ?></p>
                </section>
            </div>
        <?php endforeach; ?>

    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('dropdownToggle');
            const menu = document.getElementById('dropdownMenu');

            toggle.addEventListener('click', function(e) {
                e.preventDefault(); // évite le scroll si href="#"
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            });

            // Clic hors du menu pour le fermer
            document.addEventListener('click', function(e) {
                if (!document.getElementById('dropdown').contains(e.target)) {
                    menu.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>