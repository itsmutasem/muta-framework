<!doctype html class="h-full">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Internal Server Error</title>
</head>
<body>
<main class="grid min-h-full place-items-center bg-zinc-950 px-6 py-24 sm:py-32 lg:px-8">
    <div class="text-center">
        <div>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-white sm:text-3xl"><span class="text-red-600">500</span> | Internal Server Error</h1>

        </div>
        <div class="grid grid-cols-6 gap-4 mt-10">
            <div class="col-span-4 col-start-2 border-2 border-white/10 rounded-md p-6">
                <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-white sm:text-5xl">
                    <?= $error_data['error_name'] ?>
                </h1>
            </div>
            <div class="col-span-4 col-start-2 border-2 border-red-800 bg-red-950/50 rounded-md p-6">
                <h1 class="text-white">
                    <?= $error_data['error_message'] ?>
                </h1>
            </div>
            <div class="col-start-2 col-end-4 border-2 border-white/10 rounded-md p-6">
                <h1 class="text-white font-semibold">File</h1>
                <p class="text-white/60"><?= $error_data['error_file'] ?></p>
            </div>
            <div class="col-span-2 col-end-6 border-2 border-white/10 rounded-md p-6">
                <h1 class="text-white font-semibold">Line</h1>
                <p class="text-white/60"><?= $error_data['error_line'] ?></p>
            </div>
            <div class="col-span-4 col-start-2 border-2 border-white/10 rounded-md p-6">
                <h1 class="text-white font-semibold">Trace</h1>
                <p class="text-white/60">
                    <?= $error_data['error_trace'] ?>
                </p>
            </div>
            <div class="col-span-4 col-start-2 border-2 border-white/10 rounded-md p-6">
                <h1 class="text-white font-semibold mb-2">Code Snippet</h1>
                <div class="bg-zinc-900/30 rounded-md overflow-x-auto text-sm font-mono border border-white/10">
                    <?= $error_data['error_snippet'] ?>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>