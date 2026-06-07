<?php
echo "<h1>WordPress Requirements Check</h1>";

// Versión de PHP
echo "<h2>PHP Version</h2>";
$php_version = phpversion();
$php_ok = version_compare($php_version, '8.1', '>=');
echo "Current: " . $php_version . " " . ($php_ok ? "✓" : "✗") . "<br>";
echo "Required: 8.1+ " . ($php_ok ? "(Met)" : "(Not Met)") . "<br>";

// Extensiones PHP requeridas
echo "<h2>Required PHP Extensions</h2>";
$required_extensions = [
    'mysqli', 'json', 'curl', 'dom', 'exif',
    'fileinfo', 'hash', 'mbstring', 'openssl',
    'pcre', 'xml', 'zip'
];

foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "$ext: " . ($loaded ? "✓ Loaded" : "✗ Missing") . "<br>";
}

// Extensiones opcionales pero recomendadas
echo "<h2>Recommended PHP Extensions</h2>";
$recommended_extensions = ['imagick', 'gd'];
foreach ($recommended_extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "$ext: " . ($loaded ? "✓ Loaded" : "✗ Missing (optional)") . "<br>";
}

// Límites de PHP
echo "<h2>PHP Limits</h2>";
echo "memory_limit: " . ini_get('memory_limit') . " (256M recommended)<br>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . " (64M recommended)<br>";
echo "post_max_size: " . ini_get('post_max_size') . " (64M recommended)<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . " seconds (300 recommended)<br>";

// MySQL
echo "<h2>MySQL/MariaDB</h2>";
try {
    $mysqli = new mysqli('localhost', 'usuario', 'contraseña'); // Reemplazar con tus credenciales
    if ($mysqli->connect_error) {
        echo "Connection: ✗ Failed<br>";
    } else {
        echo "Connection: ✓ OK<br>";
        echo "Version: " . $mysqli->server_info . "<br>";
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "MySQL check failed: " . $e->getMessage() . "<br>";
}

// Permisos de escritura
echo "<h2>File Permissions</h2>";
$writable = is_writable(__DIR__);
echo "Current directory writable: " . ($writable ? "✓ Yes" : "✗ No") . "<br>";
?>
