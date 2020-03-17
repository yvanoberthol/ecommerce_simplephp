<?php
/**
 * Created by PhpStorm.
 * User: TNC TECH
 * Date: 14/03/2020
 * Time: 14:56
 */

class PanierRepository
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

    public function create($panier){

        $req = $this->bdd->bd->prepare('INSERT INTO panier (client_id) VALUES (?)');
        $req->execute([
                $panier['utilisateur_id']
            ]
        );

        return $this->bdd->bd->lastInsertId();
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare('DELETE FROM panier WHERE id_panier = ?');
        $req->execute(array($id));

    }
    public function update($panier){
        $req = $this->bdd->bd->prepare('UPDATE panier SET client_id = ? where id_panier = ?');
        $req->execute(array(
                $panier['utilisateur_id']
            )
        );
    }

    public function getByClient($idClient){
        $req = $this->bdd->bd->query("SELECT id_panier,client_id FROM panier p WHERE p.client_id=$idClient");
        return $req->fetch();
    }
}