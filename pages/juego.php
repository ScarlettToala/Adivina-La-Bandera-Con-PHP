<?php
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/header.php");
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/conocerError.php");
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/db_connect.php");

session_start();

// Inicializar variables
if (!isset($_SESSION['jugadas'])) {
    $_SESSION['jugadas'] = 0;
    $_SESSION['aciertos'] = 0;
}

// Cargar países
$url = "https://restcountries.com/v3.1/all";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Lógica
$mostrarResultado = false;
$respuestaUsuario = $_POST['respuesta'] ?? '';
$respuestaCorrecta = $_POST['correcta'] ?? '';
$jugadas = $_SESSION['jugadas'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Banderas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-50 font-sans min-h-screen flex flex-col justify-between">

<main class="flex-grow flex flex-col items-center justify-center p-6">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-xl text-center">
        <h1 class="text-3xl font-bold text-purple-700 mb-6">🎌 Juego de Banderas</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correcta'])) {
            $mostrarResultado = true;

            if ($respuestaUsuario === $respuestaCorrecta) {
                $_SESSION['aciertos']++;
                echo "<p class='text-green-600 font-medium mb-4'>✅ ¡Correcto! Era <strong>$respuestaCorrecta</strong></p>";
            } else {
                echo "<p class='text-red-600 font-medium mb-4'>❌ Incorrecto. Tú elegiste <strong>$respuestaUsuario</strong>, pero era <strong>$respuestaCorrecta</strong></p>";
            }

            $_SESSION['jugadas']++;
            $jugadas = $_SESSION['jugadas'];
        }

        echo "<h2 class='text-xl font-semibold text-purple-600 mb-4'>Progreso: $jugadas / 10</h2>";

        // Si el juego terminó
        if ($jugadas >= 10) {
            echo "<h2 class='text-2xl font-bold text-green-700 mb-2'>🎉 ¡Juego terminado!</h2>";
            echo "<p class='mb-4'>Has acertado <strong>{$_SESSION['aciertos']} / 10</strong> banderas.</p>";

            // Verifica si el usuario quiere guardar su resultado
            if (!isset($_POST['guardar'])) {
                echo '
                    <form method="post" class="space-y-4">
                        <input type="text" name="nombre" placeholder="Tu nombre" class="w-full px-4 py-2 border rounded-lg">
                        <input type="hidden" name="guardar" value="1">
                        <div class="flex justify-center gap-4">
                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">Guardar</button>
                            <button type="submit" name="reiniciar" value="1" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">No guardar</button>
                        </div>
                    </form>';
            } elseif (isset($_POST['guardar']) && !empty($_POST['nombre'])) {
                // Solo guardar si hay nombre
                $nom = $_POST['nombre'];
                $punts = $_SESSION['aciertos'];
                $temps = date('Y-m-d H:i:s');

                try {
                    $sql_insert = "INSERT INTO ranking (jug_nom, jug_punts, jug_temps) VALUES (:nom, :punts, :temps)";
                    $stmt = $db->prepare($sql_insert);

                    if ($stmt === false) {
                        die("Error en la preparación de la consulta: " . implode(", ", $db->errorInfo()));
                    }

                    $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
                    $stmt->bindValue(':punts', $punts, SQLITE3_INTEGER);
                    $stmt->bindValue(':temps', $temps, SQLITE3_TEXT);
                    
                    $resultado = $stmt->execute();

                    if (!$resultado) {
                        echo "<p class='text-red-600'>⚠️ Error al insertar.</p>";
                    } else {
                        // Esperar a redirigir hasta que todo haya finalizado
                        $_SESSION['jugadas'] = 0; // Reiniciar jugadas para evitar reenvíos
                        $_SESSION['aciertos'] = 0; // Reiniciar aciertos
                        $db->close();
                        header('Location: resultado.php'); // Redirigir después de guardar
                        exit;
                    }

                } catch (Exception $e) {
                    echo "<p class='text-red-600'>⚠️ Error: " . $e->getMessage() . "</p>";
                }

            } elseif (isset($_POST['reiniciar'])) {
                // Reiniciar el juego
                session_destroy();
                header("Location: juego.php");
                exit;
            }

        } else {
            // Mostrar nueva bandera
            $indexCorrecto = array_rand($data);
            $paisCorrecto = $data[$indexCorrecto];
            $nombreCorrecto = $paisCorrecto['name']['common'] ?? 'Desconocido';
            $bandera = $paisCorrecto['flags']['png'] ?? '';

            // Opciones incorrectas
            $arrayNombres = [];
            while (count($arrayNombres) < 4) {
                $indexExtra = array_rand($data);
                if ($indexExtra !== $indexCorrecto) {
                    $nombreExtra = $data[$indexExtra]['name']['common'] ?? '';
                    if (!in_array($nombreExtra, $arrayNombres) && $nombreExtra !== $nombreCorrecto) {
                        $arrayNombres[] = $nombreExtra;
                    }
                }
            }

            $arrayNombres[] = $nombreCorrecto;
            shuffle($arrayNombres);

            // Mostrar bandera
            echo "<img src='$bandera' alt='Bandera' class='mx-auto w-48 h-auto rounded shadow-md mb-6'>";

            // Mostrar opciones
            echo "<form method='post' class='grid grid-cols-2 gap-4'>";
            foreach ($arrayNombres as $opcion) {
                echo "<button type='submit' name='respuesta' value=\"$opcion\" class='bg-purple-100 hover:bg-purple-300 text-purple-900 font-medium py-2 rounded-lg transition'>$opcion</button>";
            }
            echo "<input type='hidden' name='correcta' value='$nombreCorrecto'>";
            echo "</form>";
        }
        ?>
    </div>
</main>

<?php include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/footer.php"); ?>

</body>
</html>
