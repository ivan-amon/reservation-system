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

      $statement = $conn->prepare("SELECT * FROM reserves WHERE email = :email");
      $statement->execute([
        ":email" => $_POST["email"]
      ]);

      $user = $statement->fetch(PDO::FETCH_ASSOC);

      header("Location: confirmation.php?id=" . $user["id"]);
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
      <?php require "partials/form.php" ?>
    </div>
  </div> 
<?php require "partials/footer.php" ?>
