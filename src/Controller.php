<?php

namespace Controller;

use \PDO;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller {
    
    private $pdo;
    private $container;

    public function __construct($container) {
        
        $this->pdo = new PDO('mysql:host=localhost;dbname=gestion_article', 'kimt', '1992');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->container = $container;
    }

    public function home (RequestInterface $request, ResponseInterface $response) {
        
        $this->container->view->render($response, 'home.twig');

    }

    public function getArticles () {

        $requete = $this->pdo->prepare('SELECT * FROM article');
        $requete->execute();
        $resultat = $requete->fetchAll();
    
        $articles = json_encode($resultat);

        return $articles;
     
    }

}