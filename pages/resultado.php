<?php
session_start();
session_destroy(); // Destruir la sesión actual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Final</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-50 text-gray-800 font-sans">

    <!-- Contenido Principal -->
    <main class="flex flex-col items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg mx-auto text-center">
            <h1 class="text-3xl font-semibold text-purple-700 mb-4">🎉 ¡Juego Terminado!</h1>
            <p class="text-lg text-gray-700 mb-6">Tu puntuación ha sido guardada. ¡Gracias por jugar!</p>

            <!-- Botones de navegación -->
            <div class="flex space-x-4 justify-center">
                <a href="juego.php" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">Volver a Jugar</a>
                <a href="ranking.php" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Ver Ranking</a>
            </div>
        </div>
    </main>

</body>
</html>

<?php 
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/footer.php");
?>
