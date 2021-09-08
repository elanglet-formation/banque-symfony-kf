<?php

namespace App\Tests\Integration\Backend;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Backend\CompteService;
use App\Entity\Compte;
use App\Entity\Client;
use App\Backend\ClientService;
use App\Business\BanqueBusiness;

class BanqueBusinessTest extends KernelTestCase
{
    private static $cnx;
    
    private $compteService;
    
    private $clientService;
    
    private $banqueBusiness;
    
    
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
        
        $this->banqueBusiness = new BanqueBusiness($this->clientService, $this->compteService);
        
        
    }
    
    
    protected function tearDown(): void
    {
        // Nettoyage du jeu de données
        self::$cnx->exec(file_get_contents('tests/scripts/clean.sql'));
    }
    
    
    
    public function testAuthentifier(): void
    {
        $client = new Client();
        $client->setId(1);
        $client->setNom('DUPONT');
        $client->setPrenom('Robert');
        $client->setAdresse('40, rue de la Paix');
        $client->setCodePostal('75007');
        $client->setVille('Paris');
        $client->setMotDePasse('secret');
        
        $clientRecupere = $this->banqueBusiness->authentifier(1, "secret");
        
        $this->assertEquals($client, $clientRecupere);
        
    }
    
    public function testAuthentifierErreur(): void
    {
        $this->expectException(\Exception::class);
        $this->banqueBusiness->authentifier(1, "toto");
        
    }
    

    
    public function testMesComptes(): void
    {
        $client = $this->clientService->rechercherClientParId(1);
        $compte = new Compte();
        $compte->setNumero(78954263);
        $compte->setSolde('5000.00');
        $compte->setClient($client);
        
        $listeComptes = $this->banqueBusiness->mesComptes($client->getId());
        $this->assertEquals(1, count($listeComptes));
        
        // OU
        /*
         * $client = $this->clientService->rechercherClientParId(1)
         * $listeComptes = $this->banqueBusiness->mesComptes(15);
         * $this->assertCount(1, $listeComptes);
         * 
         * foreach($listeComptes as $cpt)
         * {
         *  $this->assertEquals($client, $cpt->getClient());
         * }
         */
        
    }
    
    
}
