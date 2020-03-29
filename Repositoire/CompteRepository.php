<?php
/**
 * Created by PhpStorm.
 * User: TNC TECH
 * Date: 17/03/2020
 * Time: 12:04
 */
require 'BACK-END/Entites/Compte.php';
class CompteRepository
{

    private $bdd;

    /**
     * CompteRepository constructor.
     * @param $PDO
     */
    public function __construct($PDO)
    {
        $this->bdd =$PDO;
    }

    public function create(Compte $compte){

        $req = $this->bdd->bd->prepare('INSERT INTO compte(nom_compte,type_paiement,numero_tel,client_id) VALUES (?,?,?,?)');
        $req->execute(array(
            $compte->getNom(),
            $compte->getType(),
            $compte->getTelephone(),
            $compte->getClientId()
        ));
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare(' DELETE FROM compte WHERE id_compte = ?');
        $req->execute(array($id));

    }
    public function update(Compte $compte){
        $req = $this->bdd->bd->prepare('UPDATE compte SET nom_compte =?, type_paiement =?, numero_tel=? where id_compte =? ');
        $req->execute(array(
            $compte->getNom(),
            $compte->getType(),
            $compte->getTelephone(),
            $compte->getIdCompte()
        ));
    }
    public function getALL($client_id){
        $q = $this->bdd->bd->query("SELECT id_compte,nom_compte,type_paiement, numero_tel, nom, prenom FROM compte cpte,client clt WHERE cpte.client_id = clt.id_client and cpte.client_id= $client_id");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}