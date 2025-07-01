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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserve your product!</title>
  <link rel="stylesheet" href="static/style/style.css">

  <!-- Bootstrap -->
  <link 
  rel="stylesheet" 
  href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.3/darkly/bootstrap.min.css" 
  integrity="sha512-ZdxIsDOtKj2Xmr/av3D/uo1g15yxNFjkhrcfLooZV5fW0TT7aF7Z3wY1LOA16h0VgFLwteg14lWqlYUQK3to/w==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer" 
  />
  <script 
  defer
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous"
  ></script>
</head>

<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="index.html">
        <img src=static/img/logo.png style="height: 4rem;" class="d-inline-block align-text-top">
        <strong>InstaNova</strong>
      </a>  
    </div>
  </nav>

  <main>  
    
    <div class="container mt-3 p-4">
      <div class="row gx-5 align-items-center">

        <!-- Product images -->
        <div class="col-12 col-md-6 mb-3">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner radius-container">
              <div class="carousel-item active custom-ratio-4x5">
                <img src="static/img/img-1.png" class="d-block w-100" alt="InstaNova Image">
              </div>
              <div class="carousel-item custom-ratio-4x5">
                <img src="static/img/img-2.png" class="d-block w-100" alt="InstaNova Image">
              </div>
              <div class="carousel-item custom-ratio-4x5">
                <img src="static/img/img-3.png" class="d-block w-100" alt="InstaNova Image">
              </div>
              <div class="carousel-item custom-ratio-4x5">
                <img src="static/img/img-4.png" class="d-block w-100" alt="InstaNova Image">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

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

  </main>

</body>
</html>
