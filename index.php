<?php
// Importeert de Fighters class om ruimteschepen te kunnen maken
include_once 'Fighters.php';
session_start(); // Start of hervat een sessie om gegevens op te slaan

// Controleer of de schepen al in de sessie staan, initialiseer ze anders
if (!isset($_SESSION['ship1'])) {
    $_SESSION['ship1'] = new Fighters(); // Maakt een nieuw schip met standaardwaarden
}
if (!isset($_SESSION['ship2'])) {
    $_SESSION['ship2'] = new Fighters(50, 50); // Maakt een tweede schip met aangepaste waarden
}

// Verwerk acties die via POST-verzoeken binnenkomen

// Laad de eerder opgeslagen staat van de schepen
if (isset($_POST['load'])) {
    // Controleer of opgeslagen schepen in de sessie aanwezig zijn en laad deze
    if (isset($_SESSION['saved_ship1']) && isset($_SESSION['saved_ship2'])) {
        $_SESSION['ship1'] = unserialize($_SESSION['saved_ship1']);
        $_SESSION['ship2'] = unserialize($_SESSION['saved_ship2']);
    }
}

// Sla de huidige staat van de schepen op in de sessie
if (isset($_POST['save'])) {
    $_SESSION['saved_ship1'] = serialize($_SESSION['ship1']); // Slaat ship1 op
    $_SESSION['saved_ship2'] = serialize($_SESSION['ship2']); // Slaat ship2 op
}

// Reset de schepen naar de beginwaarden
if (isset($_POST['reset'])) {
    $_SESSION['ship1']->reset(); // Reset ship1 naar standaardwaarden
    $_SESSION['ship2']->reset(); // Reset ship2 naar standaardwaarden
}

// Verwerk acties voor het schieten
if (isset($_POST['shoot1']) && $_SESSION['ship1']->isAlive) {
    $damage = $_SESSION['ship1']->shoot(); // Ship1 vuurt een schot af
    $_SESSION['ship2']->hit($damage); // Ship2 ontvangt de schade
}
if (isset($_POST['shoot2']) && $_SESSION['ship2']->isAlive) {
    $damage = $_SESSION['ship2']->shoot(); // Ship2 vuurt een schot af
    $_SESSION['ship1']->hit($damage); // Ship1 ontvangt de schade
}

// Verwerk acties voor het laserwapen
if (isset($_POST['laser1']) && $_SESSION['ship1']->isAlive) {
    $damage = $_SESSION['ship1']->laserBeam(); // Ship1 vuurt een laserstraal af
    $_SESSION['ship2']->hit($damage); // Ship2 ontvangt de schade van de laser
}
if (isset($_POST['laser2']) && $_SESSION['ship2']->isAlive) {
    $damage = $_SESSION['ship2']->laserBeam(); // Ship2 vuurt een laserstraal af
    $_SESSION['ship1']->hit($damage); // Ship1 ontvangt de schade van de laser
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spaceship Battle</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link naar de CSS-stylesheet -->
</head>
<body>
    <h1>Spaceship Battle</h1>
    <div class="ships-container"> <!-- Container voor het weergeven van de schepen en hun status -->
        <div>
            <h2>Fire Dog</h2>
            <!-- Toon hitpoints en munitie van Fire Dog -->
            <p>Hit Points: <?php echo $_SESSION['ship1']->hitPoints; ?></p>
            <p>Ammo: <?php echo $_SESSION['ship1']->ammo; ?></p>
            <?php if (!$_SESSION['ship1']->isAlive): ?>
                <!-- Meld als Fire Dog is uitgeschakeld -->
                <p style="color: red;">Fire Dog is dead!</p>
            <?php endif; ?>
            <form method="post">
                <!-- Knoppen om te schieten en laserstraal te gebruiken -->
                <button type="submit" name="shoot1" <?php if (!$_SESSION['ship1']->isAlive || !$_SESSION['ship2']->isAlive) echo 'disabled'; ?>>Shoot Water Spaceship (10 damage)</button>
                <button type="submit" name="laser1" <?php if (!$_SESSION['ship1']->isAlive || !$_SESSION['ship2']->isAlive) echo 'disabled'; ?>>Use Fire Beam on Water Spaceship (30 damage)</button>
            </form>
        </div>
        <div>
            <h2>Water Spaceship</h2>
            <!-- Toon hitpoints en munitie van Water Spaceship -->
            <p>Hit Points: <?php echo $_SESSION['ship2']->hitPoints; ?></p>
            <p>Ammo: <?php echo $_SESSION['ship2']->ammo; ?></p>
            <?php if (!$_SESSION['ship2']->isAlive): ?>
                <!-- Meld als Water Spaceship is uitgeschakeld -->
                <p style="color: red;">Water Spaceship is dead!</p>
            <?php endif; ?>
            <form method="post">
                <!-- Knoppen om te schieten en laserstraal te gebruiken -->
                <button type="submit" name="shoot2" <?php if (!$_SESSION['ship2']->isAlive || !$_SESSION['ship1']->isAlive) echo 'disabled'; ?>>Shoot Fire Dog (10 damage)</button>
                <button type="submit" name="laser2" <?php if (!$_SESSION['ship2']->isAlive || !$_SESSION['ship1']->isAlive) echo 'disabled'; ?>>Use Water Freeze on Fire Dog (30 damage)</button>
            </form>
        </div>
    </div>

    <!-- Formulier voor algemene acties zoals reset, save, en load -->
    <form method="post" class="action-form">
        <button type="submit" name="reset">Reset Ships</button> <!-- Reset naar beginwaarden -->
        <button type="submit" name="save">Save State</button> <!-- Huidige staat opslaan -->
        <button type="submit" name="load">Load State</button> <!-- Eerder opgeslagen staat laden -->
    </form>
</body>
</html>
