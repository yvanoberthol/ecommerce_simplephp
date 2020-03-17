<?php
/**
 * Created by PhpStorm.
 * User: TNC TECH
 * Date: 17/03/2020
 * Time: 10:58
 */

require 'BACK-END/Entites/Adresse_l.php';
class AdresseLivraisonRepository
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

    public function create(Adresse_l $adresse_l){

        $req = $this->bdd->bd->prepare('INSERT INTO adresse_l(ville,quartier, numero_rue, client_id) VALUES (?,?,?,?)');
        $req->execute(array(
            $adresse_l->getVille(),
            $adresse_l->getQuartier(),
            $adresse_l->getNumeroRue(),
            $adresse_l->getClientId()
        ));
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare(' DELETE FROM adresse_l WHERE id_adresse_l = ?');
        $req->execute(array($id));

    }
    public function update(Adresse_l $adresse_l){
        $req = $this->bdd->bd->prepare('UPDATE adresse_l SET ville =?, quartier =?, numero_rue=? where id_adresse_l =? ');
        $req->execute(array(
            $adresse_l->getVille(),
            $adresse_l->getQuartier(),
            $adresse_l->getNumeroRue(),
            $adresse_l->getIdAdresseL()
        ));
    }
    public function getALL($client_id){
        $q = $this->bdd->bd->query("SELECT id_adresse_l,ville,quartier, numero_rue, nom, prenom FROM adresse_l adr,client clt WHERE adr.client_id = clt.id_client and adr.client_id= $client_id");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}