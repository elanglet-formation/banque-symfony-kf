<?php

namespace App\Tests\Func\Web;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;

class NavigationWebTest extends TestCase
{
    private $webDriver;
    private $baseUrl;
    
    public function setUp(): void
    {
        $this->baseUrl = "http://localhost";
        
    }
    
    public function tearDown(): void
    {
        $this->webDriver->quit();
    }
    
    public function specifierNavigateur()
    {
        return [
            ['4444', DesiredCapabilities::firefox()],
            ['4445', DesiredCapabilities::chrome()]
        ];
        
    }
    
    
    
    /**
     * @dataProvider specifierNavigateur
     */
    public function testConnexionClient($port, $caps): void
    {
        $this->webDriver = RemoteWebDriver::create('http://localhost:' .$port, $caps);
        
        // Ouverture de la page d'accueil
        $this->webDriver->get($this->baseUrl . '/');
        
        $this->webDriver->manage()->window()->setSize(new WebDriverDimension(1920, 1080));
        
        // On vérifie le titre de la page
        $titrePage = $this->webDriver->findElement(WebDriverBy::cssSelector('h2'))->getText();
        $this->assertEquals("Bienvenue sur votre Banque en ligne !!!", $titrePage);
        
        // Clique sur le lien "Accès client"
        $this->webDriver->findElement(WebDriverBy::id('link-client'))->click();
        
        // On vérifie le titre 2 "Identification Client"
        $titre2Page = $this->webDriver->findElement(WebDriverBy::cssSelector('h3'))->getText();
        $this->assertEquals("Identification Client", $titre2Page);
        
        // On remplit le formulaire
        $this->webDriver->findElement(WebDriverBy::id('identification_form_identifiant'))->sendKeys('1');
        $this->webDriver->findElement(WebDriverBy::id('identification_form_mot_de_passe'))->sendKeys('secret');
        $this->webDriver->findElement(WebDriverBy::id('identification_form_submit'))->click();
        
        // On vérifie que le lien d'accueil est présent
        $clientAccueilClient = $this->webDriver->findElement(WebDriverBy::linkText('Bonjour Robert DUPONT !'));
        $this->assertNotNull($clientAccueilClient);
        
        // On clique sur "Mes Opérations"
        $this->webDriver->findElement(WebDriverBy::id('navbarDropdown'))->click();
        // On clique sur "Mes comptes"
        $this->webDriver->findElement(WebDriverBy::linkText('Mes Comptes'))->click();
        
        // On vérifie le titre 2 "Résumé de votre situation"
        $titre2Page = $this->webDriver->findElement(WebDriverBy::cssSelector('h3'))->getText();
        $this->assertEquals("Résumé de votre situation", $titre2Page);
        
        // On vérifie le numéro de compte
        $numeroCompte = $this->webDriver->findElement(WebDriverBy::cssSelector('td:nth-child(1)'))->getText();
        $this->assertEquals("78954263", $numeroCompte);
        
        // On vérifie le solde du compte
        $numeroCompte = $this->webDriver->findElement(WebDriverBy::cssSelector('td:nth-child(1)'))->getText();
        $this->assertEquals("78954263", $numeroCompte);
        
        $soldeCompte = $this->webDriver->findElement(WebDriverBy::cssSelector('td:nth-child(2)'))->getText();
        $this->assertEquals("5000.00 €", $soldeCompte);
        
        
        
        
        $clientAccueilClient = $this->webDriver->findElement(WebDriverBy::linkText('Bonjour Robert DUPONT !'));
        $this->assertNotNull($clientAccueilClient);
    }
}
