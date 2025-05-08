<?php
// public/index.php

// 1. Bloquer l'accès direct aux fichiers PHP
$requestedFile = $_SERVER['SCRIPT_NAME'];
if ($requestedFile !== '/index.php' && preg_match('/\.php$/', $requestedFile)) {
    header("HTTP/1.0 404 Not Found");
    exit('Accès direct interdit');
}

// 2. Charger l'autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// 3. Initialiser le routeur
$router = new AltoRouter();

// 4. Définir les routes
$routes = [
    ['GET', '/', 'home.php', 'home'],
    ['GET', '/ecoles', 'allSchool.php', 'schools_list'],
    ['GET', '/ecoles/[i:id]', 'School.php', 'school_show'],
    ['GET', '/ecoles/voir-plus', 'SeeMore.php', 'see_more'],
    ['GET', '/localisation', 'loc.php', 'location'],
    ['GET', '/carte', 'map.php', 'map'],
    ['GET', '/geolocalisation', 'geo.php', 'geo'],
    ['GET', '/details', 'details.php', 'details'],
    ['GET', '/signer', 'Sign.php', 'sign'],
    ['POST', '/signer', 'Sign.php', 'sign-post'],
    ['GET', '/inscrire', 'School.php', 'sign-school'],
    ['POST', '/inscrire', 'School.php', 'sign-school-post'],
    ['POST', '/inscription-ecole', 'Sign.php', 'school_register']
];

foreach ($routes as $route) {
    $router->map($route[0], $route[1], function($params = []) use ($route) {
        // Passer les paramètres à $_GET pour compatibilité
        if (isset($params['id'])) {
            $_GET['id'] = $params['id'];
        }
        
        $file = __DIR__ . '/' . $route[2];
        if (file_exists($file)) {
            require $file;
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            exit('Fichier contrôleur introuvable');
        }
    }, $route[3]);
}

// 5. Gérer la correspondance des routes
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    // 6. Gestion des erreurs 404
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
    
    // Vérifier si un template 404 existe
    $errorPage = __DIR__ . '/404.php';
    if (file_exists($errorPage)) {
        require $errorPage;
    } else {
        echo '<h1>404 Page non trouvée</h1>';
        echo '<p>La page que vous cherchez n\'existe pas.</p>';
    }
    exit;
}