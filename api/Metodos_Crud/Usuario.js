// Importamos los módulos necesarios
const express = require('express');
const router = express.Router();
const mysql = require('mysql');
// const bcrypt = require('bcrypt'); // Se mantiene comentado como solicitaste

// --- Endpoint para el Login de Usuarios ---
router.post('/login', (req, res) => {
    // ... (El código del login se mantiene igual, no se necesita modificar)
    console.log('Recibido en /login. Body:', req.body);
    const { nombre_usuario, contrasena_usuario } = req.body;
    if (!nombre_usuario || !contrasena_usuario) {
        return res.status(400).json({ success: false, message: 'El nombre de usuario y la contraseña son requeridos.' });
    }
    const query = 'CALL SP_VerificarUsuarioLogin(?)';
    const mysqlConnection = mysql.createConnection({
        host: '142.44.161.115', user: '25-1700P4PAC2E2', password: '25-1700P4PAC2E2#e67',
        database: '25-1700P4PAC2E2', multipleStatements: true
    });
    mysqlConnection.query(query, [nombre_usuario], (err, results) => {
        if (err) {
            console.error('Error en la consulta a la base de datos:', err);
            return res.status(500).json({ success: false, message: 'Error interno del servidor.' });
        }
        if (results[0].length === 0) {
            return res.status(401).json({ success: false, message: 'Las credenciales proporcionadas son incorrectas.' });
        }
        const usuario = results[0][0];
        if (contrasena_usuario === usuario.contrasena_usuario) {
            const updateQuery = 'CALL SP_ActualizarUltimoAcceso(?)';
            mysqlConnection.query(updateQuery, [usuario.id_usuario], (updErr, updRes) => {
                if(updErr) console.error("Error al actualizar fecha de acceso:", updErr);
            });
            return res.status(200).json({ success: true, message: '¡Inicio de sesión exitoso! Redirigiendo...', redirect_url: '/dashboard.html' });
        } else {
            return res.status(401).json({ success: false, message: 'Las credenciales proporcionadas son incorrectas.' });
        }
    });
});

// --- Endpoint para el Registro (Lógica con Operaciones Separadas y Formulario Completo) ---
router.post('/registro', (req, res) => {
    console.log('Recibido en /registro. Body:', req.body);

    const { 
        primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
        fecha_nacimiento, genero, nacionalidad, tipo_identificacion,
        numero_identificacion, estado_civil,
        nombre_usuario, contrasena_usuario 
    } = req.body;

    // Validación de los campos principales que son requeridos en el formulario
    if (!primer_nombre || !primer_apellido || !fecha_nacimiento || !genero || !nacionalidad || !estado_civil || !tipo_identificacion || !numero_identificacion || !nombre_usuario || !contrasena_usuario) {
        return res.status(400).json({ success: false, message: 'Por favor, complete todos los campos requeridos.' });
    }

    const mysqlConnection = mysql.createConnection({
        host: '142.44.161.115', user: '25-1700P4PAC2E2', password: '25-1700P4PAC2E2#e67',
        database: '25-1700P4PAC2E2', multipleStatements: true
    });

    mysqlConnection.beginTransaction(err => {
        if (err) {
            console.error("Error al iniciar la transacción:", err);
            return res.status(500).json({ success: false, message: 'Error interno del servidor.' });
        }

        // --- OPERACIÓN 1: Insertar en la tabla Personas ---
        const personaQuery = 'CALL SP_InsertarPersona(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @p_id_persona_generada); SELECT @p_id_persona_generada AS id_persona;';
        
        // Preparamos los parámetros en el orden exacto que espera el SP_InsertarPersona
        const personaParams = [
            primer_nombre,
            segundo_nombre || null, // Si no se envía segundo_nombre, se pasa NULL
            primer_apellido,
            segundo_apellido || null, // Si no se envía segundo_apellido, se pasa NULL
            fecha_nacimiento,
            genero,
            nacionalidad,
            tipo_identificacion,
            numero_identificacion,
            estado_civil
        ];

        mysqlConnection.query(personaQuery, personaParams, (err, results) => {
            if (err) {
                return mysqlConnection.rollback(() => {
                    const message = err.code === 'ER_DUP_ENTRY' ? 'El número de identificación ya está registrado.' : 'Error al crear la persona.';
                    console.error("Error en Operación 1:", err);
                    res.status(409).json({ success: false, message });
                });
            }

            const nueva_persona_id = results[1][0].id_persona;

            // --- OPERACIÓN 2: Insertar en la tabla Usuarios ---
            const usuarioQuery = 'CALL SP_InsertarUsuario(?, ?, ?, @p_mensaje); SELECT @p_mensaje AS mensaje;';
            const usuarioParams = [nueva_persona_id, nombre_usuario, contrasena_usuario];

            mysqlConnection.query(usuarioQuery, usuarioParams, (err, results) => {
                if (err) {
                    return mysqlConnection.rollback(() => {
                        console.error("Error en Operación 2:", err);
                        res.status(500).json({ success: false, message: 'Error al crear el usuario.' });
                    });
                }

                const mensaje = results[1][0].mensaje;
                if (mensaje.includes('exitosamente')) {
                    mysqlConnection.commit(err => {
                        if (err) {
                            return mysqlConnection.rollback(() => {
                                console.error("Error al hacer commit:", err);
                                res.status(500).json({ success: false, message: 'Error al finalizar el registro.' });
                            });
                        }
                        res.status(201).json({ success: true, message: mensaje });
                    });
                } else {
                    mysqlConnection.rollback(() => {
                        res.status(409).json({ success: false, message: mensaje });
                    });
                }
            });
        });
    });
});

module.exports = router;
