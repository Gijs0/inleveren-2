<?php

// Definieert een klasse genaamd Fighters
class Fighters {
    // Eigenschappen voor gezondheidspunten, munitie en status (leeft of niet)
    public $hitPoints;
    public $ammo;
    public $isAlive;

    // Constructor-functie om initiële waarden in te stellen voor gezondheidspunten en munitie
    public function __construct($hitPoints = 100, $ammo = 100) {
        $this->hitPoints = $hitPoints; // Stelt de gezondheidspunten in
        $this->ammo = $ammo; // Stelt de munitie in
        $this->isAlive = true; // Standaard staat op "leeft"
    }

    // Methode om een schot af te vuren
    public function shoot() {
        if ($this->ammo > 0) { // Controleert of er munitie is
            $this->ammo--; // Vermindert munitie met 1
            return 10; // Retourneert schadewaarde voor een normaal schot
        } else {
            return 0; // Geen munitie over
        }
    }

    // Methode om een krachtige laserstraal af te vuren
    public function laserBeam() {
        if ($this->ammo >= 55) { // Controleert of er genoeg munitie is voor een laserstraal
            $this->ammo -= 55; // Vermindert munitie met 55
            return 30; // Retourneert schadewaarde voor de laserstraal
        } else {
            return 0; // Niet genoeg munitie voor laser
        }
    }

    // Methode om schade toe te brengen aan de fighter
    public function hit($damage) {
        $this->hitPoints -= $damage; // Vermindert gezondheidspunten met de opgegeven schade
        if ($this->hitPoints <= 0) { // Controleert of gezondheidspunten op zijn
            $this->isAlive = false; // Zet de status op dood als gezondheid op is
        }
    }

    // Methode om de fighter terug te zetten naar de oorspronkelijke staat
    public function reset() {
        $this->hitPoints = 100; // Zet gezondheidspunten terug op 100
        $this->ammo = 100; // Zet munitie terug op 100
        $this->isAlive = true; // Zet de status terug naar "leeft"
    }
}

?>
