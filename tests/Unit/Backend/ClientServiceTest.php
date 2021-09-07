<?php

namespace App\Tests\Unit\Backend;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Backend\ClientService;
use App\Entity\Client;
use Doctrine\Persistence\ObjectRepository;

class ClientServiceTest extends TestCase
{
    
    // On déclare l'objet à tester
    private $clientService;
    
    // On déclare les mocks nécessaires
    // 1. Un mock sur EntityManagerInterface
    private $entityManager;
    
    // 2. Un mock sur ObjectRepository
    private $repo;
    
    
    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {
        // On créé les mocks
        // 1. EntityManagerInterface
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        // 2. ObjectRepository
        $this->repo = $this->createMock(ObjectRepository::class);
        
        // On instancie l'objet à tester en lui passant le mock
        $this->clientService = new ClientService($this->entityManager);
        
    }
    
    public function testRechercherClientParId(): void
    {
        // On créé l'objet que l'on s'attend à recevoir
        $client = new Client();
        $client->setId(1);
        
        // On décrit le comportement
        $this->entityManager->expects($this->once())                          // Une seule fois...
                            ->method('getRepository')                         // ... de la méthode getRepository ...          
                            ->with('App:Client')                              // ... avec le paramètre 'App:Client' ...
                            ->willReturn($this->repo);                        // ... retourne notre Mock sur ObjectRepository ...
        
          
        $this->repo->expects($this->once())
                   ->method('find')
                   ->with(1)
                   ->willReturn($client);
                   
        // On appelle la méthode à tester
        $returnedClient = $this->clientService->rechercherClientParId(1);
        
        // Assertion : On vérifie que l'objet retourné est le même que celui attendu
        $this->assertSame($client, $returnedClient);
    }
    

    public function testAjouterClient(): void
    {
        // On créé l'objet nécessaire pour l'appel de la méthode à tester
        $client = new Client();
        
        // On décrit le comportement attendu
        // a. On s'attend à avoir un et un seul appel à 'persist' avec l'objet client
        // en paramètre.
        $this->entityManager
             ->expects($this->once())           // Un et un seul appel
             ->method('persist')                // ... à persist() ...
             ->with($client);                   // ... avec l'objet $client en paramètre
             
       // b. On s'attend à avoir ensuite un et un seul appel à 'flush'
       $this->entityManager
            ->expects($this->once())            // Un et un seul appel ...
            ->method('flush');                  // ... à flush() ...
    
    // On exéxute la méthode à tester, son exécution doit dérouler le scénario décrit:
    $this->clientService->ajouterClient($client);
    }
}
