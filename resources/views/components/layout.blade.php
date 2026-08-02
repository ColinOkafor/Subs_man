<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel App</title>
    <!-- Add Tailwind CSS for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center">
    
    <!-- This wrapper centers the slot content and restricts the width -->
    <main class="w-full max-w-md mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>