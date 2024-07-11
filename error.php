<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
}

.error-container {
    text-align: center;
}

.error-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #e74c3c;
    display: inline-block;
    animation: pulse 1s infinite;
}

.error-message {
    font-size: 1.5em;
    color: #555;
    margin-top: 20px;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-circle"></div>
        <p class="error-message">Hubo un error con el pago</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "index.php"; // URL de redirección
        }, 3000); // 3000 milisegundos = 3 segundos
    </script>
</body>
</html>
