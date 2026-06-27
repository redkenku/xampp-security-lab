<?php

declare(strict_types=1);

require_once __DIR__ . '/src/PassAccept.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="PHP integration form for the password challenge">
  <meta name="author" content="">
  <title>HackerU - Submit Password</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/clean-blog.min.css" rel="stylesheet">
</head>

<body style="background-image: url('img/background.jfif'); background-size: cover; min-height: 100vh;">
  <main class="container py-5">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <section class="p-4 shadow bg-light">
        <h1 class="h3">PHP Challenge Form</h1>
        <p>Submit the decoded password and required PHP variables to continue.</p>

        <form method="post" action="pass_accept.php" novalidate>
          <div class="form-group">
            <label for="fName">First name</label>
            <input class="form-control" id="fName" name="fName" type="text" value="Student" required>
          </div>

          <div class="form-group">
            <label for="pws">Decoded password</label>
            <input class="form-control" id="pws" name="pws" type="text" value="<?= e(expectedPassword()); ?>" required>
          </div>

          <div class="form-group">
            <label for="srt">Sort code</label>
            <input class="form-control" id="srt" name="srt" type="text" value="<?= e(expectedSortCode()); ?>" required>
          </div>

          <button class="btn btn-primary" type="submit">Submit challenge</button>
          <a class="btn btn-outline-secondary ml-2" href="index.html">Back</a>
        </form>
      </section>
    </div>
  </main>
</body>

</html>
