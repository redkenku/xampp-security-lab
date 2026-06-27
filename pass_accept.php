<?php

declare(strict_types=1);

require_once __DIR__ . '/src/PassAccept.php';

$validation = validatePassAcceptInput($_POST);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Password challenge validation result">
  <meta name="author" content="">
  <title>HackerU - PHP Challenge</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/clean-blog.min.css" rel="stylesheet">
</head>

<body style="background-image: url('img/background.jfif'); background-size: cover; min-height: 100vh;">
  <main class="container py-5">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <section class="p-4 shadow bg-light">
        <?php if (!$validation['isValid']) : ?>
          <h1 class="h3">Invalid submission</h1>
          <p>The PHP challenge could not continue because the submitted data failed validation.</p>
          <ul>
            <?php foreach ($validation['errors'] as $error) : ?>
              <li><?= e($error); ?></li>
            <?php endforeach; ?>
          </ul>
          <a class="btn btn-primary" href="challenge-form.php">Return to form</a>
        <?php else : ?>
          <h1 class="h3">Welcome, <?= e($validation['fName']); ?></h1>
          <p>The required PHP variables were accepted. The DOM below is prepared for the emitted JavaScript challenge.</p>

          <div id="d1" class="my-3 p-3 border" style="text-align: center; font-family: fantasy;">
            <div>Nested DIV found by A1()</div>
          </div>

          <div id="d2" class="my-3 p-3 border">
            <h1 class="h4">Waiting for A1()</h1>
          </div>

          <h1 id="h" class="h4 my-3" style="color: tomato; transform: rotate(180deg);">Final challenge header</h1>
          <math class="d-block my-3">Set Text In Here</math>
          <p id="challenge-result" class="alert alert-success" role="status"></p>

          <details class="mt-4">
            <summary>PHP-emitted JavaScript</summary>
            <pre class="bg-white border p-3 mt-3"><code><?= e(renderChallengeScript()); ?></code></pre>
          </details>

          <script>
<?= renderChallengeScript(); ?>
          </script>
        <?php endif; ?>
      </section>
    </div>
  </main>
</body>

</html>
