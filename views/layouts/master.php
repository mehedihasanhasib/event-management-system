<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?? "Event Management System" ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= asset('css/loader.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/alert.css') ?>">
    <style>
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(79, 70, 229, 0.1);
        }
    </style>
    <?= $style ?? "" ?>
</head>

<body>

    <?php component('loader') ?>

    <header>
        <?php component('nav') ?>
    </header>

    <main>
        <?= $content ?? "Content" ?>
    </main>

    <!-- <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Event Management System. All rights reserved.</p>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?php asset('js/submit-form.js') ?>"></script>
    <script src="<?php echo asset('js/alert.js') ?>"></script>
    <?= $script ?? "" ?>
</body>

</html>