<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <link href="<?php echo e(asset(mix('css/app.css'))); ?>" type="text/css" rel="stylesheet" />
        <meta name="csrf-token" value="<?php echo e(csrf_token()); ?>" />
        <script defer src="<?php echo e(asset(mix('js/app.js'))); ?>"></script>
    </head>
    <body>
        <div id="app">
            <app-component></app-component>
        </div>
        <script>
            window.countries = <?php echo json_encode($countries, 15, 512) ?>;
            window.states = <?php echo json_encode($states, 15, 512) ?>;
        </script>
    </body>
</html>

<?php /**PATH C:\laragon\www\netwrix\resources\views/welcome.blade.php ENDPATH**/ ?>