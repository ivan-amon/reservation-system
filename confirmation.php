<?php 
require "database.php";

//Nombre y email del usuario recien registrado
$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM reserves WHERE id = :id");
$statement->execute([
  ":id" => $id
]);

$user = $statement->fetch(PDO::FETCH_ASSOC);
?>

<?php require "partials/header.php" ?>
  <section class="container m-5 p-0 radius-container overflow-hidden">
    <div class="bg-secondary p-4 top-rounded">
      <h2>CONGRATULATIONS, <?= strtoupper($user["first_name"])?>!</h2>
    </div>
    <div class="bg-dark p-4 bottom-rounded container">
      <div class="row">
        <h4 class="col">Registration complete! You've successfully signed up with <u><?= $user["email"] ?></u>
        and claimed <?= $user["quantity"]?> products. We'll keep you update.</h4>
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
