<?php
$pdo = new PDO('mysql:host=localhost;dbname=school_registration', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$search = trim($_GET['q'] ?? '');

if (!empty($search)) {
    $db = $pdo->prepare("SELECT * FROM schools WHERE LOWER(name) LIKE LOWER(:search)");

    $db->execute(['search' => '%' . $search . '%']);
} else {
    $db = $pdo->query("SELECT * FROM schools");
}
$schools = $db->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../static/styles/ToutesLesEcoles.css" rel="stylesheet" />
    <title>Répertoire des Écoles</title>
</head>

<body>
    <header>
        <div class="logo"><span class="blue">Peda</span><span class="orange">goo</span> - Écoles</div>
    </header>

    <div class="search-bar">
        <form action="" method="GET">
            <input type="search" placeholder="Rechercher une école..." name="q" value="<?= htmlspecialchars($search) ?>" />
        </form>
    </div>
    <main class="school-list">
        <?php
        // Trier les écoles par nom, insensible à la casse
        usort($schools, function ($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        ?>

        <?php if (count($schools) === 0): ?>
            <p style="text-align:center;">Aucune école trouvée.</p>
        <?php endif; ?>

        <?php foreach ($schools as $school): ?>
            <div class="school-card">
                <img src="<?= htmlspecialchars($school['EcoleImage']) ?>" alt="École" />
                <h3><?= htmlspecialchars($school['name']) ?></h3>
                <p><?= substr(htmlspecialchars($school['description']), 0, 340)  . '...' ?></p>
                <a href="ecoles/voir-plus?id=<?= $school['id'] ?>" class="btn-gradient">Voir plus</a>
            </div>
        <?php endforeach; ?>
    </main>

</body>

</html>