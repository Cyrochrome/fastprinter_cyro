<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to CodeIgniter 4!</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/cyro.css" rel="stylesheet">
</head>

<body>
    <section class="mt-5">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </section>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cyro.js"></script>
    <script {csp-script-nonce}>
        document.getElementById("menuToggle").addEventListener('click', toggleMenu);

        function toggleMenu() {
            var menuItems = document.getElementsByClassName('menu-item');
            for (var i = 0; i < menuItems.length; i++) {
                var menuItem = menuItems[i];
                menuItem.classList.toggle("hidden");
            }
        }
    </script>
</body>