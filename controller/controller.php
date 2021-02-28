<?php
    require_once "../functions/function.php";
    require_once "../database/connection.php";

    extract($_POST);

    if(isset($valider))
    {
        if(is_string_alp($nom) && is_string_alp($prenom))
        {
            $retour = add_employe($nom, $prenom, $numero, $service);
            header("location:../ajoutEmploye.php?retour=".$retour);
        }
        else
        {
            $ok = 0;
            header("location:../ajoutEmploye.php?ok=".$ok);
        }
    }

    if(isset($supprimer))
    {
      supprimerEmp($idEmp2);
      header("location:../index.php");
    }

    if(isset($editer)){
        editerEmp($nom, $prenom, $service, $id);
        header("location:../index.php");
    }
?>