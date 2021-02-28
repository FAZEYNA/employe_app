<?php
    require_once "functions/function.php";
    require_once "database/connection.php";
    extract($_POST);
    $infoEmp = get_employes_by_id($idEmp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Employe</title>
    <link rel="stylesheet" href="/COURS/PHP_L2/TD3/assets/css/bootstrap.min.css" >
</head>
<body>
        
    <div class="container-fluid h-100 text-dark p-3">
        <div class="row justify-content-center align-items-center">
            <h1>Formulaire d'édition</h1>    
        </div>
        <hr/> 
        <div class="row justify-content-center align-items-center">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="controller/controller.php" method="POST">
                    <div class="form-group"> 
                        <label for="prenom" class="form-label">Prénom :</label>
                        <input type="text" class="form-control shadow-none " id="prenom" name="prenom" value="<?=$infoEmp["prenomEmp"]?>" >    
                    </div>
                    <div class="form-group ">
                        <label for="nom" class="form-label">Nom :</label>
                        <input type="text" class="form-control shadow-none " id="nom" name="nom" value="<?=$infoEmp["nomEmp"]?>" >
                    </div>
                    <div class="form-group">
                        <label for="service" class="form-label">Service :</label>
                        <select name="service" id="service" class="form-control shadow-none " >
                            <option name="service" value="<?= $infoEmp["idService"]?>"><?= $infoEmp["nomService"]?></option>
                            <?php $tabServices = chargerServices($infoEmp["idService"]);
                             foreach($tabServices as $tabS){
                                if($tabs["idService"] != $infoEmp["idService"]) {?>
                                    <option name="service" value="<?= $tabS["idService"]?>"><?= $tabS["nomService"]?></option>
                                <?php } 
                             }?>      
                        </select>
                    </div>   
                    <input type="submit" class="form-control shadow-none w-25 btn btn-outline-primary mt-3" value="Éditer" name="editer" id="editer">
                    <input hidden type="text" value="<?=$infoEmp["idEmp"]?>" name="id" id="id">
                    <a href="index.php" class="shadow-none w-50 btn btn-outline-primary mt-3 float-right">Liste des employés<a>
                </form>
            </div>
        </div>
    </div>
    <script src="/COURS/PHP_L2/TD3/assets/js/jquery-3.3.1.js"></script>
</body>
</html>