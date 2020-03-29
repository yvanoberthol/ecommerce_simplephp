<?php
require 'BACK-END/Entites/Rayon.php';
class RayonRepository
{

private $bdd;

    /**
     * RayonRepository constructor.
     * @param $PDO
     */
    public function __construct($PDO)
    {
        $this->bdd = $PDO;
    }

    public function create(Rayon $rayon){

        $req = $this->bdd->bd->prepare('INSERT INTO rayon(nom) VALUES(:nom)');
        $req->execute(array( 'nom' =>$rayon->getNom()));
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare('DELETE FROM rayon WHERE id_rayon = ?');
        $req->execute(array($id));

    }
    public function update(Rayon $rayon){
        $req = $this->bdd->bd->prepare('UPDATE rayon SET nom = :nom where id_rayon = :id; ');
        $req->execute(array(
            'nom' => $rayon->getNom(),
            'id' => $rayon->getIdRayon()));
    }
    public function getALL(){

        $q = $this->bdd->bd->query("SELECT * FROM rayon");
        return $q->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getbyname($name){
        $req = $this->bdd->bd->prepare("SELECT * FROM rayon WHERE  nom like ?");
        $req->execute(array($name.'%'));
        return $req->fetchAll();
    }
}