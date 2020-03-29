<?php
/**
 * Created by PhpStorm.
 * User: TNC TECH
 * Date: 23/03/2020
 * Time: 22:44
 */
require 'BACK-END/Entites/Commande.php';
class CommandeRepository
{
    private $bdd;

    /**
     * RayonRepository constructor.
     * @param $PDO
     */
    public function __construct($PDO)
    {
        $this->bdd =$PDO;
    }

    public function create(Commande $commande){

        $req = $this->bdd->bd->prepare('INSERT INTO commande(date_commande,panier_id, montant, adresse_l_id, client_id, compte_id) VALUES (CURRENT_DATE(),?,?,?,?,?)');
        $req->execute(array(
            $commande->getPanierId(),
            $commande->getMontant(),
            $commande->getAdresseLId(),
            $commande->getClientId(),
            $commande->getCompteId()
        ));
    }

    public function getALL(){
        $q = $this->bdd->bd->query('SELECT * FROM commande');
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}