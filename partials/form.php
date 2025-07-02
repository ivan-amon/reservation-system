<div class="col-12 col-md-6 mt-3">
  <form method="POST" action="index.php" class="bg-dark pb-3 radius-container overflow-hidden">
    <h3 class="p-4 mb-4 bg-secondary top-rounded">RESERVE NOW!</h3>
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
