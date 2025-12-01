<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener los datos del API
$url = "https://restcountries.com/v3.1/all";
$response = @file_get_contents($url);

if ($response === false) {
    echo "<p style='color:red'>❌ No se pudo obtener la lista de países. Intenta nuevamente más tarde.</p>";
}

$data = json_decode($response, true);

if (!is_array($data)) {
    echo "<p style='color:red'>❌ Los datos del API no se pudieron procesar correctamente.</p>";
}
?>
