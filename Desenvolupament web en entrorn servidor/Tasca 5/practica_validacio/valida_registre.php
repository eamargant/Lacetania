<?php
// Rep el formulari, el valida i redirigeix.
session_start();
require_once __DIR__ . '/includes/validacio.php';

// Només peticions POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}

//Comprovem el token CSRF
$token = $_POST['csrf'] ?? '';
if (!is_string($token) || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
    http_response_code(403);
    exit('Petició no vàlida (403).');
}

//Llegir cada camp: ha d'existir i ser un string. Si no, el deixem buit.
$camps = ['nom', 'email', 'edat', 'telefon', 'poblacio'];
$dades = [];
foreach ($camps as $camp) {
    $valor = $_POST[$camp] ?? '';
    $dades[$camp] = is_string($valor) ? trim($valor) : '';
}

$email = mb_strtolower($dades['email']);
$telefon = str_replace([' ', '-'], '', $dades['telefon']);

// Validem
$errors = [];
$errors['nom'] = validarNom($dades['nom']);
$errors['email'] = validarEmail($email);
$errors['edat'] = validarEdat($dades['edat']);
$errors['telefon'] = validarTelefon($telefon);
$errors['poblacio'] = validarPoblacio($dades['poblacio']);

// Treure els camps sense error
$errors = array_filter($errors);

// Si hi ha errors les desen amb les dades enviades i tornem al formulari
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades'] = $dades;
    header('Location: registre.php');
    exit;
}

// Tot correcte
$_SESSION['resultat'] = [
    'nom'      => $dades['nom'],
    'email'    => $email,
    'edat'     => (int)$dades['edat'],
    'telefon'  => $telefon,
    'poblacio' => normalitzarPoblacio($dades['poblacio']),
];
header('Location: resultat.php');
exit;
