<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?? "Event Management System" ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= $style ?? "" ?>
</head>

<body>

    <header>
        <?php component('nav') ?>
    </header>

    <main>
        <?= $content ?? "Content" ?>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Event Management System. All rights reserved.</p>
    </footer>

    <?= $script ?? "" ?>
</body>

</html>