<?php
require "../Entites/Utilisateur.php";
class UtilisateurRepository
{

    private $bdd;

    /**
     * RayonRepository constructor.
     */
    public function __construct($PDO)
    {
        $this->bdd = $PDO;
    }

    public function create(Utilisateur $user)
    {

        $req = $this->bdd->bd->prepare('INSERT INTO utilisateur(username,password,role) VALUES (:username,:password,:role)');
        $req->execute(array(
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()));
    }

    Public function delete($id)
    {

        $req = $this->bdd->bd->prepare(' DELETE FROM utilisateur WHERE id_utilisateur = ?');
        $req->execute(array($id));

    }

    public function update(Utilisateur $user)
    {
        $req = $this->bdd->bd->prepare('UPDATE utilisateur SET username = :username, password = :password, role = :role where id_utilisateur = :id');
        $req->execute(array(
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'id' => $user->getIdUtilisateur()
        ));
    }

    public function getALL()
    {

        $q = $this->bdd->bd->query("SELECT * FROM utilisateur");
        return $q->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getONE($id)
    {

    }

    public function getbyname($name)
    {
        $req = $this->bdd->bd->prepare("SELECT * FROM utilisateur WHERE  username like ?");
        $req->execute(array($name . '%'));
        return $req->fetchAll();
    }

    public function verifier($username, $password){
        $req = $this->bdd->bd->prepare("SELECT * FROM utilisateur WHERE username = ? and password = ?");
        $req->execute(array($username,$password));
        return $req->fetch();
    }
}
