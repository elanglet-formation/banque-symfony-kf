<?php

namespace App\Tests\Integration\Backend;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Backend\CompteService;
use App\Entity\Compte;
use App\Entity\Client;
use App\Backend\ClientService;

class CompteServiceTest extends KernelTestCase
{
    private static $cnx;
    
    private $compteService;
    
    private $clientService;
    
    
    
    
    public static function setUpBeforeClass(): void
    {
        // Mise en place d'une connexion PDO pour la mise en place et le nettoyage de la base de test.
        self::$cnx = new \PDO('mysql:host=localhost; port=3306;dbname=banquesf_test', 'banquesf', 'banquesf');
        // Pour lever des exceptions en cas de problèmes de connexion
        self::$cnx->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    
    
    protected function setUp(): void
    {
        // Initialisation du jeu de données
        self::$cnx->exec(file_get_contents('tests/scripts/init.sql'));
        
        // Récupération de l'EntityManager
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        
        // OU
        // $kernel = self::bootKernel();
        // $entityManager = self::$container->get('doctrine')->getManager();
        
        // Récupérer le ClientService
        $this->clientService = new ClientService($entityManager);
        
        // Récupérer le ClientService
        $this->compteService = new CompteService($entityManager);
        
        
    }
    
    
    protected function tearDown(): void
    {
        // Nettoyage du jeu de données
        self::$cnx->exec(file_get_contents('tests/scripts/clean.sql'));
    }
    
    
    public function testRechercherCompteParNumero(): void
    {
        $client = $this->clientService->rechercherClientParId(1);
        $compte = new Compte();
        $compte->setNumero(78954263);
        $compte->setSolde('5000.00');
        $compte->setClient($client);
        
        $compteRecupere = $this->compteService->rechercherCompteParNumero(78954263);
        $this->assertEquals($compte, $compteRecupere);
        
        
    }
    
    
    public function testRechercherComptesClient(): void
    {
        $client = $this->clientService->rechercherClientParId(1);
        $listeComptes = $this->compteService->rechercherComptesClient($client);
        $this->assertCount(1, $listeComptes);
        
        foreach ($listeComptes as $cpt)
        {
            $this->assertEquals($client, $cpt->getClient());
        }
        
    }
    
    
    public function testAjouterCompte(): void
    {
        $client = $this->clientService->rechercherClientParId(1);
        $compte = new Compte();
        $compte->setNumero(45698752);
        $compte->setSolde('10000.00');
        $compte->setClient($client);
        
        $this->compteService->ajouterCompte($compte);
        
        $compteRecupere = $this->compteService->rechercherCompteParNumero(45698752);
        
        // On compare l'objet récupéré avec l'objet référencé
        $this->assertEquals($compte, $compteRecupere);
        
    }
    
    
}
