
<?php
require 'BACK-END/Entites/Ligne_panier.php';

class LignePanierRepository
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

    public function create(Ligne_panier $ligne_panier){

        $req = $this->bdd->bd->prepare('INSERT INTO ligne_panier (produit_id,panier_id,quantite_com,sous_total) VALUES (?,?,?,?)');
        $req->execute(array(
                $ligne_panier->getProduitId(),
                $ligne_panier->getPanierId(),
                $ligne_panier->getQuantiteCom(),
                $ligne_panier->getSousTotal()
            )
        );
    }
    Public function delete($id){

        $req = $this->bdd->bd->prepare(' DELETE FROM ligne_panier WHERE id_ligne_panier = ?');
        $req->execute(array($id));

    }
    public function update(Ligne_panier $ligne_panier){
        $req = $this->bdd->bd->prepare('UPDATE ligne_panier SET produit_id = ?,panier_id = ?,quantite_com = ?,sous_total = ?,Categorie_id = ? where id_ligne_panier = ?');
        $req->execute(array(
                $ligne_panier->getProduitId(),
                $ligne_panier->getPanierId(),
                $ligne_panier->getQuantiteCom(),
                $ligne_panier->getSousTotal()
            )
        );
    }

    public function updateQte(Ligne_panier $ligne_panier){
        $req = $this->bdd->bd->prepare('UPDATE ligne_panier SET quantite_com = ?, sous_total = ? where produit_id = ?');
        $req->execute(array(
                $ligne_panier->getQuantiteCom(),
                $ligne_panier->getSousTotal(),
                $ligne_panier->getProduitId()
            )
        );
    }

    public function getALL($idClient){
        $req = $this->bdd->bd->query("SELECT id_ligne_panier,produit_id,p.nom,p.prix_vente,panier_id,quantite_com,sous_total FROM ligne_panier lp, produit p, panier pa WHERE lp.produit_id=p.id_Produit and pa.client_id=$idClient");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getONEByProduit($produit_id){
        $req = $this->bdd->bd->query("SELECT id_ligne_panier, quantite_com FROM ligne_panier WHERE produit_id = $produit_id");
        return $req->fetch();
    }

    public function getOne($id){
        $req = $this->bdd->bd->query("SELECT id_ligne_panier, quantite_com FROM ligne_panier WHERE id_ligne_panier = $id");
        return $req->fetch();
    }
}