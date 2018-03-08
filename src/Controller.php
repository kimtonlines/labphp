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
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $this->container = $container;
    }

    public function home (RequestInterface $request, ResponseInterface $response) {
        
        return $this->container->twig->render('home.twig', array());

    }


    public function create (RequestInterface $request, ResponseInterface $response, $args) {

        if ($request->isMethod('POST') && !empty($request->getParam('libelle'))) {

            $libelle = $request->getParam('libelle');
            $qte =  $request->getParam('qte');
            $pu =  $request->getParam('pu');

            $requete = $this->pdo->prepare('INSERT INTO article (libelle, qte, pu) VALUES (:libelle, :qte, :pu)');
            $requete->bindParam('libelle', $libelle);
            $requete->bindParam('qte', $qte);
            $requete->bindParam('pu', $pu);
            $requete->execute();

         return $response->withStatus(302)->withHeader('Location', '/article');
        }
        
        
       return $this->container->twig->render('add.twig', array());
        
    }

    public function update (RequestInterface $request, ResponseInterface $response, $args) {

        $resultat = $this->read($request, $response, $args);

        if ($resultat) {     

            if (isset($_POST['modifier']) && !empty($_POST['libelle'])) {

                $id = $request->getParam('id');
                $libelle = $request->getParam('libelle');
                $qte =  $request->getParam('qte');
                $pu =  $request->getParam('pu');
    
                $requete = $this->pdo->prepare('UPDATE article SET libelle =  :libelle , qte = :qte , pu = :pu WHERE id =  :id');
                $requete->bindParam('id', $id);
                $requete->bindParam('libelle', $libelle);
                $requete->bindParam('qte', $qte);
                $requete->bindParam('pu', $pu);
                $requete->execute();
    
             return $response->withStatus(302)->withHeader('Location', '/article');
            }

            return $this->container->twig->render('update.twig', array('article' => $resultat));
            } else {
            return $response->withStatus(302)->withHeader('Location', '/');
            }
       
        
        
    }

    public function list (RequestInterface $request, ResponseInterface $response) {

        $requete = $this->pdo->prepare('SELECT * FROM article');
        $requete->execute();
        $resultat = $requete->fetchAll();

            return $this->container->twig->render('list.twig.html', array('articles' => $resultat)); 

    }

    public function show (RequestInterface $request, ResponseInterface $response, $args) {

        $id = (int) $args['id'];

        $requete = $this->pdo->prepare('SELECT * FROM article WHERE id = :id');
        $requete->bindParam('id', $id,PDO::PARAM_INT);
        $requete->execute();
        $resultat = $requete->fetch();

        if ($resultat) {     
        return $this->container->twig->render('show.twig', array('article' => $resultat));
        } else {
        return $response->withStatus(302)->withHeader('Location', '/');
        }
     
    }

    public function read (RequestInterface $request, ResponseInterface $response, $args) {

        $id = (int) $args['id'];

        $requete = $this->pdo->prepare('SELECT * FROM article WHERE id = :id');
        $requete->bindParam('id', $id,PDO::PARAM_INT);
        $requete->execute();
        $resultat = $requete->fetch();

        return $resultat;
    }

    public function delete (RequestInterface $request, ResponseInterface $response, $args) {

        $id = $args['id'];

        $requete = $this->pdo->prepare('DELETE FROM article WHERE id = :id LIMIT 1');
        $requete->bindParam('id', $id,PDO::PARAM_INT);
        $requete->execute();

        return $response->withStatus(302)->withHeader('Location', '/article');
        }

    public function truncate (RequestInterface $request, ResponseInterface $response) {

            $requete = $this->pdo->prepare('TRUNCATE TABLE article');
            $requete->execute();

            return $response->withStatus(302)->withHeader('Location', '/article');

    }

}