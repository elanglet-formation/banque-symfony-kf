<?php

namespace App\Tests\Unit\Business;

use PHPUnit\Framework\TestCase;
use App\Entity\Client;
use App\Backend\ClientService;
use App\Backend\CompteService;
use App\Business\BanqueBusiness;

class BanqueBusinessTest extends TestCase
{
    
    private $banqueBusiness;
    
    private $client;
    
    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {
       // On créé un Stub pour ClientService
       // Une implémentation qui ne contient que la méthode 'rechercherClientParId'
       // renvoyant toujours le même objet client.
       
        $this->client = new Client();
        $this->client->setId(1);
        $this->client->setMotdepasse('password');
       
        // On créé un Stub ClientService
        $clientService = $this->createMock(ClientService::class);
        // On spécifie la méthode à définir dans cette implémentation vide
        $clientService->method('rechercherClientParId')
                      ->willReturn($this->client);
        
       // On créé un Stub CompteService
       $compteService = $this->createMock(CompteService::class);
       
       
       // Enfin on instancie l'objet à tester
       $this->banqueBusiness = new BanqueBusiness($clientService, $compteService);
       
    }

    
    public function testAuthentifier(): void
    {
        // On appelle la méthode à tester  avec des paramètres cohérents par rapport à ce que renvoie le Stub
        $clientReturned = $this->banqueBusiness->authentifier(1, 'password');
        
        $this->assertNotNull($clientReturned);
        $this->assertSame($this->client, $clientReturned);
    }
    
    
    public function testAuthentifierEchec(): void
    {
        // On déclare une Exception de type \Exception va être déclenchée. A déclarer avent tout le reste
        $this->expectException(\Exception::class);
        // ... avec le message exact: "Erreur d'authentification."
        $this->expectExceptionMessage("Erreur d'authentification.");
        
        // On appelle la méthode à tester  avec des paramètres cohérents par rapport à ce que renvoie le Stub
        $clientReturned = $this->banqueBusiness->authentifier(1, 'falsePassword');
        
        
    }
}
