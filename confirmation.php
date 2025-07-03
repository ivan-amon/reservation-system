<?php 
require "database.php";

session_start();
?>

<?php if(isset($_SESSION["user"])): ?>
  <?php require "partials/header.php" ?>
    <section class="container m-5 p-0 radius-container overflow-hidden">
      <div class="bg-secondary p-4 top-rounded">
        <h2>CONGRATULATIONS, <?= strtoupper($_SESSION["user"]["first_name"])?>!</h2>
      </div>
      <div class="bg-dark p-4 bottom-rounded container">
        <div class="row">
          <h4 class="col">Registration complete! You've successfully signed up with <u><?= $_SESSION["user"]["email"] ?></u>
          and claimed <?= $_SESSION["user"]["quantity"]?> products. We'll keep you update.</h4>
        </div>
        <div class="row mt-3 container justify-content-center">
          <div class="col-auto">
            <a href="index.php">
              <button type="button" class="btn btn-primary col px-5 py-2">Home</button>
            </a>
          </div>
        </div>
      </div> 
    </section>
  <?php require "partials/footer.php" ?>
<?php else: ?>
  <p>HTTP 404: NOT FOUND</p>
<?php endif ?>


