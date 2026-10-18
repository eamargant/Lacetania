<?php
session_start();
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';

#igual que index.php
if (isset($_SESSION['usuari'])) {
    redirigeix('cataleg.php');
}

$email = '';
$error = null;
$expirada = ($_GET['expirada'] ?? '') === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';

    $usuari = buscaUsuari($dades['usuaris'], $email);
    #El password_verify compara la contrasenya introduida amb la contrasenya hashejada
    if ($usuari !== null && password_verify($contrasenya, $usuari['contrasenya'])) {
        session_regenerate_id(true);
        #Enviem les dades del usuari a la sessio i comnçem a comptar el temps de la ultima activitat
        $_SESSION['usuari'] = [
            'nom'   => $usuari['nom'],
            'email' => $usuari['email'],
            'rol'   => $usuari['rol'],
            'login' => time(),
        ];
        $_SESSION['ultimaActivitat'] = time();

        redirigeix('cataleg.php');
    }

    $error = 'Credencials incorrectes';
}

$titol = 'Iniciar sessió';
require_once __DIR__ . '/inc/capcalera.php';
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3">Iniciar sessió</h1>

                <?php if ($expirada): ?>
                    <div class="alert alert-warning">La sessió ha caducat per inactivitat</div>
                <?php endif; ?>

                <?php if ($error !== null): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>

                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="<?= e($email) ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="contrasenya" class="form-label">Contrasenya</label>
                        <input type="password" id="contrasenya" name="contrasenya" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
