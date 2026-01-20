<!DOCTYPE html>
<html>
<head>
    <title>Error 500</title>
</head>
<body>
    <h1>Error del servidor</h1>
    <p>Ocurrió un error. Por favor, inténtalo más tarde.</p>
    <?php if (defined('DEBUG') && DEBUG === true && isset($message)): ?>
        <pre><?php echo htmlspecialchars($message); ?></pre>
    <?php endif; ?>
</body>
</html>