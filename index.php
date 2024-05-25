<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convertir Palabras a Números</title>

    <!-- Bootstrap CSS -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Calculadora de texto</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post" id="conversion-form" class="mb-4">
                    <label for="words" class="form-label">Ingresa la cadena de palabras:</label>
                    <div class="input-group mb-3">
                        <input id="words" name="words" class="form-control" placeholder="Ingrese el texto a calcular" title="Ingrese el texto a calcular"/>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="convertTextToNumber">Convertir</button>
                        </div>
                    </div>
                </form>
                <div id="resultContainer"></div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>

    <!-- Script JavaScript -->
    <script src="public/js/functions.js"></script>
    <script src="public/js/ConvertTextToNumber.js"></script>
    <script src="public/js/loadVoices.js"></script>
</body>
</html>