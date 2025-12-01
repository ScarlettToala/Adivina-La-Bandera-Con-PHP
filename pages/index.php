<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adivinar la bandera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-50 font-sans min-h-screen flex flex-col">

    <!-- Contenido principal -->
    <main class="flex-grow flex items-center justify-center">
        <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full text-center border border-purple-200">
            <h1 class="text-3xl font-bold text-purple-700 mb-4">🌍 Adivina la bandera</h1>

            <a href="juego.php" class="inline-block mb-6 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                🎮 Jugar
            </a>

            <h2 class="text-xl font-semibold text-purple-800 mb-2">País del día</h2>

            <?php 
            include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/conocerError.php");

            // Cargar datos de países
            $url = "https://restcountries.com/v3.1/all";
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            // Generar nueva pregunta
            $indexAletorio = array_rand($data);
            $paisRandom = $data[$indexAletorio];
            $nombre = $paisRandom['name']['common'] ?? 'Desconocido';
            $bandera = $paisRandom['flags']['png'] ?? '';

            // Mostrar bandera y nombre
            echo "<img src='$bandera' alt='Bandera' class='mx-auto w-40 h-auto rounded-lg border border-purple-200 mb-4'>";
            echo "<p class='text-lg font-medium text-purple-900'>$nombre</p>";
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-purple-800 text-purple-100 px-6 py-8 text-center border-t-4 border-purple-500">
        <h3 class="text-2xl font-semibold mb-4">🌍 Juego de Banderas</h3>
        
        <div class="flex justify-center flex-wrap gap-4 mb-4 text-purple-300">
            <a href="ranking.php" class="hover:underline hover:text-purple-100 transition">Ranking</a>
            <a href="https://restcountries.com/" target="_blank" class="hover:underline hover:text-purple-100 transition">API de Países</a>
            <a href="https://github.com/" target="_blank" class="hover:underline hover:text-purple-100 transition">GitHub</a>
        </div>

        <div class="text-sm text-purple-200">
            &copy; <?php echo date("Y"); ?> Juego de Banderas. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
