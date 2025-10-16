<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Resume Builder</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen flex flex-col items-center justify-center text-center">

    <main>
        <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
            Welcome to the <span class="text-blue-700">Resume Builder</span>
        </h1>

        <p class="text-gray-700 text-lg mb-8 max-w-xl mx-auto">
            Create a stunning, job-winning resume in minutes using our smart and easy-to-use builder.
        </p>

        <a href="<?php echo e(url('/resume')); ?>"
           class="inline-block bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-blue-800 hover:shadow-lg transition duration-200 ease-in-out">
           Get Started
        </a>
    </main>

</body>
</html>
<?php /**PATH C:\laragon\www\resume2\resources\views/welcome.blade.php ENDPATH**/ ?>