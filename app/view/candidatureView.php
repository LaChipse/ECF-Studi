<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require_once('../view/head.php');
    ?>
        
    <body style="height: 100vh">
        
        <?php
            require_once('../view/header.php');
            require_once('../model/Users.php');

            $instructeur = $instructeurModel->findBy(array('validation' => 'En attente'));

            $userModel = new UserModel();
        ?>
        
        <div class="news container my-4">

        <div class="row mt-5">
        <?php if ( count($instructeur) > 0) 
        { 
        ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                    <th scope="col">Numero<i class="fa-solid fa-sort" style="margin-left: 15px"></i></th>
                                    <th scope="col">Nom<i class="fa-solid fa-sort" style="margin-left: 15px"></i></th> 
                                    <th scope="col">Prenom<i class="fa-solid fa-sort" style="margin-left: 15px"></i></th>
                                    <th scope="col">Mail<i class="fa-solid fa-sort" style="margin-left: 15px"></i></th>              
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach($instructeur as &$valueInst) {
                            $user = $userModel->findBy(array('id' => $valueInst["userid"]));

                            foreach($user as &$valueUs) {
                        ?>
                            <tr>
                                <td class="m-2"><?php echo $valueUs["id"] ?></td>
                                <td class="m-2"><?php echo $valueUs["nom"] ?></td>
                                <td class="m-2"><?php echo $valueUs["prenom"] ?></td>
                                <td class="m-2"><?php echo $valueUs["mail"] ?></td>
                                
                                <td class="actions">
                                    <a href="../controller/candidature.php?id=<?php echo $valueInst['id']?>&valid=right" class="valide m-2"><i class="fa-solid fa-circle-check fa-xl"></i></a>
                                </td>
                                <td class="actions">
                                    <a href="../controller/candidature.php?id=<?php echo $valueInst['id']?>&valid=wrong" class="trash m-2"><i class="fa-solid fa-circle-xmark fa-xl"></i></a>
                                </td>
                            </tr>
                        <?php 
                            }
                        }
                        ?>
                        </tbody>
                    </table> 
                </div>
        <?php 
        }
        ?>
        </div>
        
        <script type="text/javascript" src="../asset/js/tri.js"> 
        </script> 
    </body>
</html>