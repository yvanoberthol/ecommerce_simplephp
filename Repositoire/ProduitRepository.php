<?php
require 'BACK-END/Entites/Produit.php';
class ProduitRepository
{
    private $bdd;
    /**
     * RayonRepository constructor.
     */
    public function __construct($PDO)
    {
        $this->bdd =$PDO;
    }

    public function create(Produit $cat){

        $req = $this->bdd->bd->prepare('INSERT INTO produit (nom,prix_achat,prix_vente,quantite,Categorie_id,quantite_alert,photo_produit) VALUES (?,?,?,?,?,?,?)');
        $req->execute(array(
            $cat->getNom(),
            $cat->getPrixAchat(),
            $cat->getPrixVente(),
            $cat->getQuantite(),
            $cat->getCategorieId(),
            $cat->getquantite_alert(),
            $cat->getPhotoProduit()
            )
        );
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare(' DELETE FROM produit WHERE id_Produit = ?');
        $req->execute(array($id));

    }
    public function update(Produit $cat){
        $req = $this->bdd->bd->prepare('UPDATE produit SET nom = ?,prix_achat = ?,prix_vente = ?,quantite = ?,Categorie_id = ?,quantite_alert = ?,photo_produit= ? where id_Produit = ?');
        $req->execute(array(
                $cat->getNom(),
                $cat->getPrixAchat(),
                $cat->getPrixVente(),
                $cat->getQuantite(),
                $cat->getCategorieId(),
                $cat->getquantite_alert(),
                $cat->getPhotoProduit(),
                $cat->getIdProduit(),
            )
        );
    }
    public function getALL(){
        $req = $this->bdd->bd->query("SELECT id_Produit, p.nom, prix_achat, prix_vente, quantite, c.nom as nomc, Categorie_id, quantite_alert,photo_produit FROM produit p, categorie c WHERE c.id_Categorie=p.Categorie_id");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getALLByCategorie($idCategorie){
        $req = $this->bdd->bd->query("SELECT id_Produit, p.nom, prix_achat, prix_vente, quantite, c.nom as nomc, Categorie_id, quantite_alert,photo_produit FROM produit p, categorie c WHERE c.id_Categorie=p.Categorie_id and c.id_Categorie=$idCategorie");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getONE($id){

    }
    public function getbyname($name){
        $req = $this->bdd->bd->prepare("SELECT id_Produit, p.nom, prix_achat, prix_vente, quantite, c.nom as nomc, Categorie_id, quantite_alert, photo_produit  FROM produit p, categorie c WHERE c.id_Categorie=p.Categorie_id and  p.nom like ?");
        $req->execute(array($name.'%'));
        return $req->fetchAll();
    }
}