<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Directa API Geolocalización</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Tailwind CSS CDN para estilos básicos y responsividad (se usa junto con Bootstrap) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #1a202c; /* Fondo oscuro */
            color: #e2e8f0; /* Texto claro */
            display: flex;
            flex-direction: column; /* Cambiado a columna para apilar elementos */
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .container {
            background-color: #2d3748; /* Color de tarjeta más oscuro */
            border-radius: 0.75rem; /* Bordes redondeados */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); /* Sombra sutil */
            padding: 2rem;
            width: 100%;
            max-width: 900px; /* Aumentado el ancho máximo para la tabla */
            margin-bottom: 1rem; /* Espacio entre el contenedor y la tabla */
        }
        .input-group {
            display: flex;
            gap: 0.5rem;
        }
        .input-field {
            flex-grow: 1;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #4a5568;
            background-color: #4a5568;
            color: #e2e8f0;
            outline: none;
        }
        .input-field::placeholder {
            color: #a0aec0;
        }
        .button-primary {
            background-color: #f53003; /* Rojo personalizado */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
            border: none;
        }
        .button-primary:hover {
            background-color: #e02a00; /* Rojo más oscuro al pasar el ratón */
        }
        .result-area {
            background-color: #1a202c;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            overflow-x: auto; /* Para desplazamiento horizontal si el JSON es muy largo */
            white-space: pre-wrap; /* Para que el texto se envuelva */
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #a0aec0;
        }
        .error-message {
            background-color: #dc3545; /* Rojo de error */
            color: white;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            text-align: center;
            display: flex; /* Para alinear el icono y el texto */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
            gap: 0.5rem; /* Espacio entre el icono y el texto */
        }
        /* Estilos adicionales para la tabla Bootstrap en tema oscuro */
        .table-dark-custom {
            --bs-table-bg: #2d3748;
            --bs-table-striped-bg: #2a323f;
            --bs-table-striped-color: #e2e8f0;
            --bs-table-active-bg: #3c4a60;
            --bs-table-active-color: #e2e8f0;
            --bs-table-hover-bg: #3c4a60;
            --bs-table-hover-color: #e2e8f0;
            --bs-table-border-color: #4a5568;
            color: #e2e8f0;
        }
        .table-dark-custom th {
            background-color: #4a5568;
        }
        /* Estilos para la imagen del gatito */
        .cat-gif {
            width: 40px; /* Ajusta el tamaño del GIF */
            height: 40px;
            object-fit: contain; /* Asegura que la imagen se ajuste sin distorsionarse */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-2xl font-bold text-center mb-6">Prueba Directa API Geolocalización</h1>

        <div class="input-group mb-4">
            <input
                type="number"
                id="direccionGeoId"
                placeholder="ID Dirección Geográfica (ej. 3)"
                class="input-field"
            >
            <button
                id="fetchDireccionGeoBtn"
                class="button-primary"
            >
                Buscar Datos
            </button>
        </div>

        <h2 class="text-xl font-semibold mt-6 mb-3">Respuesta JSON Cruda:</h2>
        <div id="resultOutput" class="result-area">
            <p class="text-gray-400">El JSON de la respuesta aparecerá aquí.</p>
        </div>

        <h2 class="text-xl font-semibold mt-6 mb-3">Datos en Tabla:</h2>
        <div id="tableOutput">
            <p class="text-gray-400 text-center">Los datos se mostrarán en una tabla aquí.</p>
        </div>

        <div id="errorMessage" class="error-message hidden">
            <!-- Imagen del gatito GIF -->
            <img id="catGif" src="images/gato.png" alt="Gatito animado" class="cat-gif">
            <span></span> <!-- Espacio para el texto del mensaje de error -->
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const direccionGeoIdInput = document.getElementById('direccionGeoId');
            const fetchDireccionGeoBtn = document.getElementById('fetchDireccionGeoBtn');
            const resultOutputDiv = document.getElementById('resultOutput');
            const tableOutputDiv = document.getElementById('tableOutput');
            const errorMessageDiv = document.getElementById('errorMessage');
            const catGif = document.getElementById('catGif'); // Obtener la imagen del gatito
            const errorMessageTextSpan = errorMessageDiv.querySelector('span:last-child'); // Obtener el span del texto

            // Ocultar la imagen del gatito inicialmente
            catGif.style.display = 'none';

            fetchDireccionGeoBtn.addEventListener('click', async function() {
                const id = direccionGeoIdInput.value;
                errorMessageDiv.classList.add('hidden'); // Ocultar errores anteriores
                catGif.style.display = 'none'; // Asegurarse de que la imagen esté oculta al inicio de una nueva búsqueda
                resultOutputDiv.innerHTML = '<p class="text-gray-400">Cargando...</p>';
                tableOutputDiv.innerHTML = '<p class="text-gray-400 text-center">Cargando datos de la tabla...</p>';

                if (!id) {
                    resultOutputDiv.innerHTML = '<p class="text-gray-400">Por favor, ingresa un ID.</p>';
                    tableOutputDiv.innerHTML = '<p class="text-gray-400 text-center">Por favor, ingresa un ID.</p>';
                    return;
                }

                try {
                    const response = await fetch(`http://localhost:3000/Geolocalizacion/direcciones_geograficas/${id}`);

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ message: 'Error desconocido o respuesta no JSON.' }));
                        
                        // Mostrar la imagen del gatito cuando hay un error
                        catGif.style.display = 'block'; 
                        errorMessageTextSpan.textContent = `Error HTTP ${response.status}: ${errorData.message || response.statusText}. Asegúrate que tu API de Node.js esté corriendo en http://localhost:3000.`;
                        
                        errorMessageDiv.classList.remove('hidden');
                        resultOutputDiv.innerHTML = '<p class="text-gray-400">No se pudo obtener la dirección geográfica.</p>';
                        tableOutputDiv.innerHTML = '<p class="text-gray-400 text-center">Error al cargar los datos de la tabla.</p>';
                        return;
                    }

                    let data = await response.json();
                    
                    resultOutputDiv.textContent = JSON.stringify(data, null, 2);

                    if (!Array.isArray(data)) {
                        data = [data];
                    }

                    if (data.length > 0) {
                        const firstItem = data[0];
                        const headers = Object.keys(firstItem);

                        let tableHtml = '<div class="table-responsive"><table class="table table-striped table-bordered table-dark table-dark-custom"><thead><tr>';
                        headers.forEach(key => {
                            const formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
                            tableHtml += `<th>${formattedKey}</th>`;
                        });
                        tableHtml += '</tr></thead><tbody>';

                        data.forEach(item => {
                            tableHtml += '<tr>';
                            headers.forEach(key => {
                                const value = item[key];
                                tableHtml += `<td>${value !== null ? value : ''}</td>`;
                            });
                            tableHtml += '</tr>';
                        });
                        tableHtml += '</tbody></table></div>';
                        tableOutputDiv.innerHTML = tableHtml;
                    } else {
                        tableOutputDiv.innerHTML = '<p class="text-gray-400 text-center">No se encontraron datos para mostrar en la tabla.</p>';
                    }

                } catch (error) {
                    console.error('Error al buscar la dirección geográfica:', error);
                    
                    // Mostrar la imagen del gatito cuando hay un error de conexión
                    catGif.style.display = 'block'; 
                    errorMessageTextSpan.textContent = `Error de conexión: ${error.message}. Asegúrate que tu API de Node.js esté corriendo en http://localhost:3000.`;
                    
                    errorMessageDiv.classList.remove('hidden');
                    resultOutputDiv.innerHTML = '<p class="text-gray-400">Error al buscar la dirección geográfica.</p>';
                    tableOutputDiv.innerHTML = '<p class="text-gray-400 text-center">Error al cargar los datos de la tabla.</p>';
                }
            });
        });
    </script>
</body>
</html>
