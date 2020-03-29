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

        $req = $this->bdd->bd->prepare('INSERT INTO panier (client_id, soumis) VALUES (?,false)');
        $req->execute([
                $panier['client_id']
            ]
        );

        return $this->bdd->bd->lastInsertId();
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare('DELETE FROM panier WHERE id_panier = ?');
        $req->execute(array($id));

    }

    public function submitPanier($id_panier){
        $req = $this->bdd->bd->prepare('UPDATE panier SET soumis = true where id_panier = ?');
        $req->execute(array(
                $id_panier
            )
        );
    }

    public function getByClient($idClient){
        $req = $this->bdd->bd->query("SELECT id_panier,client_id FROM panier p WHERE p.soumis = false and p.client_id=$idClient");
        return $req->fetch();
    }
}