<?php
require "database.php";

$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST") {

  //Form validation
  if(empty($_POST["first-name"]) || empty($_POST["last-name"]) || empty($_POST["email"]) || empty($_POST["quantity"])) {
    $error = "Please, fill all the fields!";

  } else if(!str_contains($_POST["email"], "@")) {
    $error = "Email format is incorrect.";

  } else if($_POST["quantity"] <= 0 || $_POST["quantity"] > 3) {
    $error = "Select 3 units at most.";

  } else { //Persist in DB (avoiding SQL injection)

    $statement = $conn->prepare("SELECT * FROM reserves WHERE email = :email");
    $statement->bindParam(":email", $_POST["email"]);
    $statement->execute();

    if($statement->rowCount() > 0) {
      $error = "User with email " . $_POST["email"] . " is already logged.";

    } else { //Persist data in DB
      $statement = $conn->prepare("INSERT INTO reserves (first_name, last_name, email, quantity)
        VALUES (:first_name, :last_name, :email, :quantity)");
      $statement->execute([
        ":first_name" => $_POST["first-name"],
        ":last_name" => $_POST["last-name"],
        ":email" => $_POST["email"],
        ":quantity" => $_POST["quantity"]
      ]);
    }
    
  }
}
?>

<?php require "partials/header.php" ?>
  <div class="container mt-3 p-4">
    <div class="row gx-5 align-items-center">

      <!-- Carousel -->
      <?php require "partials/carousel.php" ?>

      <!-- Form -->
      <div class="col-12 col-md-6 mt-3">
        <form method="POST" action="index.php" class="bg-dark pb-3 radius-container">
          <h3 class="p-4 mb-4 bg-secondary custom-rounded">RESERVE NOW!</h3>
          <?php if($error != null): ?>
            <p class="text-danger mb-4 px-4">
              <?= $error ?>
            </p>
          <?php endif ?>
          <div class="mb-3 px-4">
            <label for="first-name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first-name" name="first-name" aria-describedby="user-name">
          </div>
          <div class="mb-3 px-4">
            <label for="last-name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last-name" name="last-name">
          </div>
          <div class="mb-3 px-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="px-4 mb-2">
            <label for="quantity" class="form-label">Quantity</label>
              <input type="number" class="form-control" id="quantity" name="quantity">
          </div>
          <button type="submit" class="btn btn-primary m-4">RESERVE</button>
        </form>
      </div>
    </div>
  </div> 
<?php require "partials/footer.php" ?>
