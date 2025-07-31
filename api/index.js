
// curl -v http://localhost:3000/Geolocalizacion/direcciones_geograficas/3
// Codigo para provar la conexion


//constante para el paquete de express
const express = require('express');
//constante para el paquete de mysql
const mysql = require('mysql');
// Middleware para permitir peticiones cruzadas (Cross-Origin Resource Sharing) por el login esta esto 
const cors = require('cors'); 
//variable para los metodos de express
var app = express();
// Habilitar CORS para todas las rutas.
// Esto permitirá que tu frontend de Laravel y tu archivo HTML local hagan solicitudes a esta API.
app.use(cors()); 

//constante para el paquete de bodyparser
const bp = require('body-parser');

//enviando datos JSON a NodeJS API
app.use(bp.json());

// Enviando datos JSON a NodeJS API
app.use(express.json());
app.use(express.urlencoded({ extended: true }));


var mysqlConnection = mysql.createConnection({
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});



// verificacion de la conexion a la base de datos 
mysqlConnection.connect((err) => {
    if (!err) {
        console.log('Conexión a la base de datos exitosa');
    } else {
        console.log('Error al conectar a la base de datos ',err);
    }
});
//ejecutar el server : en puerto 3000
app.listen(3000, () => console.log('Servidor en puerto 3000'));



// --- 6. DEFINICIÓN DE RUTAS ---
// Aquí se cargan todos los módulos de rutas del equipo.

// Módulo Personas (Osman)
// ejemplo de un get                          http://localhost:3000/personas/1
app.use('/personas', require('./Metodos_Crud/Personas.js')(mysqlConnection));

// Módulo Geolocalización (Dilmer)
// ejemplo de un get                          http://localhost:3000/Geolocalizacion/direcciones_geograficas/2    
const GeolocalizacionRoutes = require('./Metodos_Crud/Geolocalizacion.js');
app.use('/Geolocalizacion', GeolocalizacionRoutes);

// Módulo Reservas (Sarai)
const ReservasRoutes = require('./Metodos_Crud/Reservas.js');
app.use('/reservas', ReservasRoutes);

// Módulo Servicios (Sarai)
const ServicioRoutes = require('./Metodos_Crud/Servicio.js');
app.use('/servicios', ServicioRoutes);

// Módulo Reportes (Elizabeth)
const Reporte_Generadosrouter = require ('./Metodos_Crud/reportes.js');
app.use('/reportes', Reporte_Generadosrouter);

// Henrry Módulo Eventos    get  http://localhost:3000/eventos
const EventosRoutes = require('./Metodos_Crud/Eventos.js');
app.use('/Eventos', EventosRoutes);

// Módulo Actividades (Henrry)
const ActividadesRoutes = require('./Metodos_Crud/Actividades.js');
app.use('/Actividades', ActividadesRoutes);

// Módulo Asistencias (Henrry)
const AsistenciasRouter = require('./Metodos_Crud/Asistencias.js');
app.use('/Asistencias', AsistenciasRouter);

// Módulo Administración y Control (Daniel Rivera)
const Administracion_controlRoutes = require('./Metodos_Crud/Administracion_control.js');
app.use('/Administracion_control', Administracion_controlRoutes);

// Módulo de Usuarios (Login)
const UsuariosRoutes = require('./Metodos_Crud/Usuario.js');
app.use('/Usuario', UsuariosRoutes);

