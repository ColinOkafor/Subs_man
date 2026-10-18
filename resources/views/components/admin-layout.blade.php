<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubsMan Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col">

    <nav class="bg-white shadow-sm border-b border-gray-200 shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold text-orange-500">SubsMan</span>
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400 border border-gray-200 rounded px-2 py-0.5">Admin</span>
                </div>
                <div class="flex items-center gap-4">
                    {{ $navActions ?? '' }}
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

</body>
</html>