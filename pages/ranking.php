<!-- Encabezado y Navegación -->
<header class="bg-purple-700 p-4 shadow-md">
    <nav class="container mx-auto flex justify-between items-center text-white">
        <ul class="flex space-x-6">
            <li><a href="juego.php" class="hover:text-purple-300 transition">Volver a Jugar</a></li>
            <li><a href="index.php" class="hover:text-purple-300 transition">Home</a></li>
        </ul>
    </nav>
</header>

<?php
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/conocerError.php");
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/header.php");
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/db_connect.php");

// Conectar a la base de datos
$resultado = $db->query("SELECT * FROM ranking ORDER BY jug_punts DESC, jug_temps ASC");

if (!$resultado) {
    die("Error al ejecutar la consulta");
}

echo "<div class='p-8 bg-purple-50 min-h-screen flex flex-col items-center'>";
echo "<h1 class='text-3xl font-semibold text-purple-700 mb-8'>🎖️ Ranking de Jugadores</h1>";

echo "<table class='table-auto w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden'>";
echo "<thead>
        <tr class='bg-purple-600 text-white'>
            <th class='px-6 py-4 text-left'>Jugador</th>
            <th class='px-6 py-4 text-left'>Puntos</th>
            <th class='px-6 py-4 text-left'>Fecha</th>
        </tr>
      </thead>";
echo "<tbody>";

$rank = 1;
while ($jugador = $resultado->fetchArray(SQLITE3_ASSOC)) {
    // Resaltar los tres primeros lugares
    $rowClass = '';
    if ($rank == 1) {
        $rowClass = 'bg-purple-100';
    } elseif ($rank == 2) {
        $rowClass = 'bg-purple-200';
    } elseif ($rank == 3) {
        $rowClass = 'bg-purple-300';
    }

    echo "<tr class='hover:bg-purple-50 transition-all duration-200 $rowClass'>";
    echo "<td class='px-6 py-4'>$jugador[jug_nom]</td>";
    echo "<td class='px-6 py-4 text-center'>$jugador[jug_punts]</td>";
    echo "<td class='px-6 py-4 text-center'>$jugador[jug_temps]</td>";
    echo "</tr>";

    $rank++;
}

echo "</tbody></table>";

echo "</div>";

$db->close();
include("/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/includes/footer.php");
?>
