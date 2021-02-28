<?php
    require_once "../../models/datasource.php";
   
    if(isset($_GET["idDomaine"])){
        $id = $_GET["idDomaine"];
        $req = "SELECT * FROM sujet WHERE idDomaineF = $id";
        global $ds;
        $exe = $ds->query($req);
        $sujets = $exe->fetchAll();
        if (empty($sujets)) {
            echo json_encode("0");
        } else {
            echo json_encode($sujets);
        }
    }
