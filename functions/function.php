<?php

    //Vérifier la validité du nom et du prénom
    function is_string_alp($string)
    {
        $string = trim(strip_tags(htmlspecialchars($string)));
        if(preg_match("/^[ \p{L}-]*$/u", $string)) //AVEC ACCENTS and space
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function get_services()
    {
        global $db;
        // Sélection de tous les noms de services dans la BD
        $reponse = $db->query("SELECT * FROM service ORDER BY nomService");
        $donnees = $reponse -> fetchAll(PDO::FETCH_ASSOC) ;
        return $donnees;
    }

    function create_numeroEmp()
    {
        global $db;
        // Recupération de l'id le plus grand qui est donc le dernier
        $reponse = $db->query("SELECT MAX(idEmp) FROM employe"); 
        $donnees = $reponse -> fetch(); 
        $idMax = $donnees[0] + 1;
        // Création du matricule EMP_JJMMAAAA_ID
        return 'EMP_'.date('dmY').'_'.$idMax; 
    }

    //Ajout d'un employé dans la base de données
    function add_employe($nom, $prenom, $numero, $service)
    {
        global $db;
        $requete = "INSERT INTO employe(nomEmp, prenomEmp, numeroEmp, idServiceF) VALUES('$nom','$prenom','$numero',$service)";
        return $db->exec($requete); 
    }    
    // Fonction qui recupère tous les employés
    function get_employes()
    {
        global $db;
        $reponse = $db->query("SELECT * FROM employe, service WHERE employe.idServiceF = service.idService AND employe.etatEmploye = 1 ORDER BY idEmp DESC");
        $donnees = $reponse -> fetchAll(PDO::FETCH_ASSOC) ;
        return $donnees;
    }

    function get_numberOfEmployees()
    {
        global $db;
        $reponse = $db->query('SELECT COUNT(*) FROM employe WHERE etatEmploye = 1');
        $donnees = $reponse->fetch();
        return intval($donnees[0]);
    }

    function get_employeParPage($premier, $parPage)
    {
        global $db;
        $requete = $db->prepare('SELECT * FROM employe, service WHERE employe.idServiceF = service.idService AND employe.etatEmploye = 1 ORDER BY idEmp DESC LIMIT :premier, :parpage');
        $requete->bindValue(':premier', $premier, PDO::PARAM_INT);
        $requete->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $requete->execute();
        $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $donnees;
    }

    function supprimerEmp($id)
    {
        global $db;
        $requete = $db->prepare('UPDATE employe SET etatEmploye=0 WHERE idEmp=:id');
        return $requete->execute(array(
            ':id' => $id));
    }

    function get_employes_by_id($id){
        global $db;
        $reponse = $db->prepare("SELECT * FROM employe, service WHERE employe.idServiceF = service.idService AND employe.etatEmploye = 1 AND idEmp = :id");
        $reponse->bindValue(':id', $id, PDO::PARAM_INT);
        $reponse->execute();
        $donnees = $reponse -> fetchAll(PDO::FETCH_ASSOC) ;
        return $donnees[0];
    }

    function editerEmp($nom, $prenom, $idServ, $id)
    {
        global $db;
        $requete = $db->prepare('UPDATE employe SET nomEmp=:nom, prenomEmp=:prenom, idServiceF=:idServ WHERE idEmp=:id');
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':prenom', $prenom);
        $requete->bindValue(':idServ', $idServ, PDO::PARAM_INT);
        $requete->bindValue(':id', $id, PDO::PARAM_INT);
        return $requete->execute();
    }

    function chargerServices($idServ){
        global $db;
        $reponse = $db->query("SELECT * FROM service WHERE idService != $idServ");
        $donnees = $reponse -> fetchAll(PDO::FETCH_ASSOC) ;
        return $donnees;
    }
?>