<?php
require 'BACK-END/Entites/Categorie.php';
class CategorieRepository
{
    private $bdd;
    /**
     * RayonRepository constructor.
     */
    public function __construct($PDO)
    {
        $this->bdd =$PDO;
    }

    public function create(Categorie $cat){

        $req = $this->bdd->bd->prepare('INSERT INTO categorie(nom,rayon_id) VALUES (:nom,:rayon_id)');
        $req->execute(array(
            'nom'=>$cat->getNom(),
            'rayon_id'=>$cat->getRayonId()));
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare(' DELETE FROM categorie WHERE id_Categorie = ?');
        $req->execute(array($id));

    }
    public function update(Categorie $cat){
        $req = $this->bdd->bd->prepare('UPDATE categorie SET nom =:nom, rayon_id =:rayon_id where id_Categorie =:id ');
        $req->execute(array(
            'nom' => $cat->getNom(),
            'rayon_id' => $cat->getRayonId(),
            'id' => $cat->getIdCategorie()
        ));
    }
    public function getALL(){
        $q = $this->bdd->bd->query("SELECT id_Categorie,C.nom as nomC,R.nom as nomR, C.rayon_id FROM categorie C,rayon R WHERE C.rayon_id=R.id_rayon");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getALLByRayon($idRayon){
        $q = $this->bdd->bd->query("SELECT id_Categorie,C.nom as nomC,R.nom as nomR, C.rayon_id FROM categorie C,rayon R WHERE C.rayon_id=R.id_rayon AND C.rayon_id = $idRayon");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getbyname($name){
        $req = $this->bdd->bd->prepare("SELECT id_Categorie,C.nom as nomC,R.nom as nomR FROM categorie C,rayon R WHERE C.rayon_id=R.id_rayon and  C.nom like ?");
        $req->execute(array($name.'%'));
        return $req->fetchAll();
    }
}