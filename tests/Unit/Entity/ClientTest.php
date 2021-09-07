<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Client;

class ClientTest extends TestCase
{
    
    private $client;
    
    public function setUp(): void
    {
        // L'objet à tester sera recréé avant chaque test :
        $this->client = new Client();
        // On met en place les données de test (fixtures)
        $this->client->setId(1);
        $this->client->setNom("DUPONT");
        $this->client->setPrenom("Robert");
        $this->client->setAdresse("40 rue de la Paix");
        $this->client->setVille("Paris");
        $this->client->setCodePostal("75000");
        $this->client->setMotDePasse("secr3t");
    }
    
    public function testGetId(): void
    {
        // On appelle la méthode à tester
        $id = $this->client->getId();
        // On fait les vérifications (assertions)
        $this->assertEquals(1, $id);
    }
    
    public function testSetId(): void
    {
        $this->client->setId(99);
        // Pas le choix que d'appeler getId() pour controler la valeur
        // Pas de soucis ! A condition que getId() soit testée !!!!
        $this->assertEquals(99, $this->client->getId());
    }
    
    public function testGetNom(): void
    {
        $this->assertEquals("DUPONT", $this->client->getNom());
    }
    
    public function testSetNom(): void
    {
        $this->client->setNom("DUPOND");
        $this->assertEquals("DUPOND", $this->client->getNom());
    }
    
    public function testGetPrenom(): void
    {
        $this->assertEquals("Robert", $this->client->getPrenom());
    }
    
    public function testSetPrenom(): void
    {
        $this->client->setPrenom("Karl");
        $this->assertEquals("Karl", $this->client->getPrenom());
    }
    
    public function testGetAdresse(): void
    {
        $this->assertEquals("40 rue de la Paix", $this->client->getAdresse());
        
    }
    
    public function testSetAdresse(): void
    {
        $this->client->setAdresse("Adresse de test");
        $this->assertEquals("Adresse de test", $this->client->getAdresse());
    }
    
    public function testGetVille(): void
    {
        $this->assertEquals("Paris", $this->client->getVille());
        
    }
    
    public function testSetVille(): void
    {
        $this->client->setVille("Rennes");
        $this->assertEquals("Rennes", $this->client->getVille());
    }
    
    public function testGetCodePostal(): void
    {
        $this->client->setVille("75000");
        $this->assertEquals("75000", $this->client->getCodepostal());
    }
    
    public function testSetCodePostal(): void
    {
        $this->client->setCodepostal("35000");
        $this->assertEquals("35000", $this->client->getCodepostal());
    }
    
    public function testGetMotDePasse(): void
    {
        $this->client->setVille("secr3t");
        $this->assertEquals("secr3t", $this->client->getMotdepasse());
    }
    
    public function testSetMotDePasse(): void
    {
        $this->client->setMotdepasse("mdp");
        $this->assertEquals("mdp", $this->client->getMotdepasse());
    }
    
    }

