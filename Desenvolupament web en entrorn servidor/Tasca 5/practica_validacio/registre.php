<?php
// Formulari de registre: mostra els errors i els valors anteriors.
session_start();

// Token CSRF
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$errors = $_SESSION['errors'] ?? [];
$dades = $_SESSION['dades'] ?? [];

// Un cop llegits els errors, s'esborren.
unset($_SESSION['errors'], $_SESSION['dades']);

$titol = "Registre d'Usuari";
include __DIR__ . '/includes/header.php';
?>
<h1>Registre d'Usuari</h1>
<p><a href="index.php">← Tornar a l'inici</a></p>

<form action="valida_registre.php" method="post">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

    <div class="camp <?= isset($errors['nom']) ? 'camp-error' : '' ?>">
        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" maxlength="50" required
               value="<?= htmlspecialchars($dades['nom'] ?? '') ?>">
        <?php if (isset($errors['nom'])): ?>
            <p class="error"><?= htmlspecialchars($errors['nom']) ?></p>
        <?php endif; ?>
    </div>

    <div class="camp <?= isset($errors['email']) ? 'camp-error' : '' ?>">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required
               value="<?= htmlspecialchars($dades['email'] ?? '') ?>">
        <?php if (isset($errors['email'])): ?>
            <p class="error"><?= htmlspecialchars($errors['email']) ?></p>
        <?php endif; ?>
    </div>

    <div class="camp <?= isset($errors['edat']) ? 'camp-error' : '' ?>">
        <label for="edat">Edat *</label>
        <input type="text" id="edat" name="edat" inputmode="numeric" required
               value="<?= htmlspecialchars($dades['edat'] ?? '') ?>">
        <?php if (isset($errors['edat'])): ?>
            <p class="error"><?= htmlspecialchars($errors['edat']) ?></p>
        <?php endif; ?>
    </div>

    <div class="camp <?= isset($errors['telefon']) ? 'camp-error' : '' ?>">
        <label for="telefon">Telèfon</label>
        <input type="tel" id="telefon" name="telefon"
               value="<?= htmlspecialchars($dades['telefon'] ?? '') ?>">
        <?php if (isset($errors['telefon'])): ?>
            <p class="error"><?= htmlspecialchars($errors['telefon']) ?></p>
        <?php endif; ?>
    </div>

    <div class="camp <?= isset($errors['poblacio']) ? 'camp-error' : '' ?>">
        <label for="poblacio">Població *</label>
        <input type="text" id="poblacio" name="poblacio" maxlength="50" required
               value="<?= htmlspecialchars($dades['poblacio'] ?? '') ?>">
        <?php if (isset($errors['poblacio'])): ?>
            <p class="error"><?= htmlspecialchars($errors['poblacio']) ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="boto">Registrar-me</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
