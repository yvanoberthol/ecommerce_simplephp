<?php
require 'BACK-END/Entites/Client.php';

class ClientRepository
{
    private $bdd;

    /**
     * RayonRepository constructor.
     */
    public function __construct($PDO)
    {
        $this->bdd = $PDO;
    }

    public function create(Client $client)
    {
        $req = $this->bdd->bd->prepare('INSERT INTO client(nom,prenom,email,tel,login,password) VALUES (?,?,?,?,?,?)');
        $req->execute(array(
            $client->getNom(),
            $client->getPrenom(),
            $client->getEmail(),
            $client->getTelephone(),
            $client->getLogin(),
            $client->getPassword()
        ));
    }

    public function updateInformation(Client $client)
    {
        $req = $this->bdd->bd->prepare('UPDATE client set nom=?,prenom=?,email=?,tel=? where id_client=?');
        $req->execute(array(
            $client->getNom(),
            $client->getPrenom(),
            $client->getEmail(),
            $client->getTelephone(),
            $client->getId()
        ));
    }


    public function updateIdentifiant(Client $client)
    {
        $req = $this->bdd->bd->prepare('UPDATE client set login=?,password=? where id_client=?');
        $req->execute(array(
            $client->getLogin(),
            $client->getPassword(),
            $client->getId()
        ));
    }

    public function verifier($username, $password){
        $req = $this->bdd->bd->prepare('SELECT * FROM client WHERE login = ? and password = ?');
        $req->execute(array($username,$password));
        return $req->fetch();
    }
}