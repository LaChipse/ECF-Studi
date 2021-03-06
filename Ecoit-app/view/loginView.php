<!DOCTYPE html>
<html style="height: 100%">

<?php
  require('head.php');
?>
<body style="height: 100vh">

<?php
  require('../view/header.php');
?>

  <main class="container form-signin col-sm-8 col-lg-5 mt-5" style="margin: auto">
    <form action="../controller/connexion.php" method="post" name="login">
      <h1 class="mb-5 fw-normal text-center">Connexion</h1>

      <div class="form-floating">
        <input type="email" class="form-control mb-4" id="floatingInput" name="mail" placeholder="name@example.com" required>
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control mb-4" id="floatingPassword" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>

      <div>
        <button type="submit" class="btn">Se connecter</button>
      </div>

      <!-- Affichage des erreurs si il y en a eu -->
      <?php if ( isset($_SESSION['error']) ) { ?>
        <p class="msgError"><?php echo $_SESSION['error']; 
        unset($_SESSION['error']); ?></p>

      <?php } elseif ( isset($_SESSION['user']) ) {
              if ( ($_SESSION['user'] == FALSE) && (isset($_SESSION['validate']) && $_SESSION['validate'] == FALSE )) { ?>
        <p class="msgError"><?php echo "Votre candidature n'a pas encore été validé"; unset($_SESSION['user']);?></p>

      <?php } elseif ($_SESSION['user'] == FALSE) { ?>
        <p class="msgError"><?php echo "Le nom d'utilisateur ou le mot de passe est incorrect."; unset($_SESSION['user'])?></p>

      <?php } } ?>

    </form>
  </main>
</body>

</html>