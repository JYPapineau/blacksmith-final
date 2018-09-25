<?php require 'settings.php'; ?>
<?php require 'blacksmith.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Functional Fishing with PHP</title>
  <link rel="stylesheet" href="blacksmith.css">
</head>
<body>
  <h1>Blacksmith</h1>
  <div id="response" class="response">
    <?php if (isset($response)): ?>
      <?php echo $response; ?>
    <?php endif; ?> 
  </div>
  <form method="post">
    <input type="text" name="action" class="action">
  </form>
  <script src="blacksmith.js"></script>
</body>
</html>