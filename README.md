# Sistema de Gestión de Medicamentos

## Descripción del Proyecto

Sistema web de gestión de medicamentos desarrollado en PHP que permite administrar información sobre medicamentos, incluyendo su registro, consulta, modificación y eliminación. El sistema está diseñado con arquitectura MVC (Modelo-Vista-Controlador) para garantizar una estructura de código organizada y mantenible.

## Tecnologías Utilizadas

- **PHP** - Lenguaje de programación principal
- **MySQL/MariaDB** - Sistema de gestión de base de datos
- **HTML5/CSS3** - Frontend y presentación
- **JavaScript** - Funcionalidades del lado cliente
- **Apache** - Servidor web (incluido en XAMPP)
- **Bootstrap** - Framework CSS para diseño responsivo

## Estructura del Proyecto

```
medicina/
├── controllers/          # Controladores MVC
│   ├── DefaultController.php
│   ├── MedicamentoController.php
│   └── ...
├── models/              # Modelos de datos
│   ├── Medicamento.php
│   └── ...
├── views/               # Vistas y plantillas
│   ├── layouts/
│   ├── medicamento/
│   └── ...
├── libs/                # Librerías y utilidades
│   ├── FrontController.php
│   ├── Controller.php
│   ├── Model.php
│   └── View.php
├── assets/              # Recursos estáticos
│   ├── css/
│   ├── js/
│   └── img/
├── config/              # Archivos de configuración
│   └── Config.php
├── database/            # Scripts de base de datos
│   └── medicina.sql
├── index.php           # Punto de entrada principal
└── README.md           # Este archivo
```

## Arquitectura MVC

### Modelos (Models)
- **Medicamento.php**: Modelo principal para la gestión de medicamentos
- Manejo de operaciones CRUD (Create, Read, Update, Delete)
- Conexión y consultas a la base de datos

### Vistas (Views)
- **layouts/**: Plantillas base del sistema
- **medicamento/**: Vistas específicas para medicamentos
- Separación clara entre lógica y presentación

### Controladores (Controllers)
- **DefaultController.php**: Controlador por defecto
- **MedicamentoController.php**: Controlador principal de medicamentos
- Manejo de rutas y lógica de negocio

### Librerías (Libs)
- **FrontController.php**: Controlador frontal para enrutamiento
- **Controller.php**: Clase base para controladores
- **Model.php**: Clase base para modelos
- **View.php**: Clase base para vistas

## Requisitos del Sistema

- **XAMPP** (Apache + MySQL + PHP)
- **PHP 7.4** o superior
- **MySQL 5.7** o superior (o MariaDB equivalente)
- **Navegador web moderno**

## Instalación y Configuración

### 1. Preparación del Entorno

1. **Instalar XAMPP**:
   - Descargar desde [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Instalar en la ruta por defecto (C:\xampp)

2. **Iniciar Servicios**:
   - Abrir XAMPP Control Panel
   - Iniciar Apache y MySQL

### 2. Configuración del Proyecto

1. **Clonar/Copiar el proyecto**:
   ```bash
   # El proyecto debe estar en:
   C:\xampp\htdocs\DWes\Trabajo\ProyectoMedicamento\medicina
   ```

2. **Configurar la base de datos**:
   - Abrir phpMyAdmin: `http://localhost/phpmyadmin`
   - Crear base de datos llamada `medicina`
   - Importar el archivo `database/medicina.sql`

3. **Configurar conexión**:
   - Editar `config/Config.php`
   - Verificar parámetros de conexión:
     ```php
     const DB_HOST = 'localhost';
     const DB_NAME = 'medicina';
     const DB_USER = 'root';
     const DB_PASS = '';
     ```

### 3. Arrancar el Proyecto

1. **Acceso vía navegador**:
   ```
   http://localhost/DWes/Trabajo/ProyectoMedicamento/medicina
   ```

2. **Verificar funcionamiento**:
   - La página principal debe cargar sin errores
   - Las funcionalidades de medicamentos deben estar disponibles

## Uso del Sistema

### Funcionalidades Principales

1. **Gestión de Medicamentos**:
   - Listar todos los medicamentos
   - Agregar nuevos medicamentos
   - Editar información de medicamentos existentes
   - Eliminar medicamentos
   - Búsqueda y filtrado

2. **Navegación**:
   - Interfaz intuitiva y responsiva
   - Menús de navegación claros
   - Formularios validados

### Rutas Principales

- `/` - Página principal
- `/medicamento` - Lista de medicamentos
- `/medicamento/create` - Crear nuevo medicamento
- `/medicamento/edit/{id}` - Editar medicamento
- `/medicamento/delete/{id}` - Eliminar medicamento

## Base de Datos

### Tabla: medicamentos
```sql
CREATE TABLE medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2),
    stock INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Configuración Avanzada

### Variables de Entorno

Editar `config/Config.php` para personalizar:

```php
<?php
class Config {
    // Configuración de base de datos
    const DB_HOST = 'localhost';
    const DB_NAME = 'medicina';
    const DB_USER = 'root';
    const DB_PASS = '';
    
    // Configuración de la aplicación
    const APP_NAME = 'Sistema de Medicamentos';
    const APP_VERSION = '1.0.0';
    
    // Configuración de seguridad
    const SECURE_SESSION = true;
    const SESSION_TIMEOUT = 3600; // 1 hora
}
?>
```

## Desarrollo y Personalización

### Agregar Nuevos Controladores

1. Crear archivo en `controllers/`:
   ```php
   <?php
   class NuevoController extends Controller {
       public function index() {
           // Lógica del controlador
       }
   }
   ?>
   ```

2. Agregar rutas en `FrontController.php`

### Agregar Nuevos Modelos

1. Crear archivo en `models/`:
   ```php
   <?php
   class NuevoModel extends Model {
       // Propiedades y métodos del modelo
   }
   ?>
   ```

### Agregar Nuevas Vistas

1. Crear archivos en `views/`
2. Usar el sistema de plantillas existente
3. Mantener consistencia en el diseño

## Mantenimiento

### Logs del Sistema
- Revisar logs de Apache: `C:\xampp\apache\logs\error.log`
- Revisar logs de MySQL: `C:\xampp\mysql\data\*.err`

### Respaldos
1. **Base de datos**:
   ```bash
   mysqldump -u root medicina > backup_medicina.sql
   ```

2. **Archivos del proyecto**:
   - Crear copia de la carpeta completa del proyecto

### Actualizaciones
1. Respaldar antes de actualizar
2. Probar en entorno de desarrollo
3. Aplicar cambios gradualmente

## Solución de Problemas

### Errores Comunes

1. **Error de conexión a base de datos**:
   - Verificar que MySQL esté ejecutándose
   - Comprobar credenciales en Config.php
   - Verificar que la base de datos existe

2. **Página en blanco**:
   - Activar display_errors en PHP
   - Revisar logs de errores
   - Verificar permisos de archivos

3. **Rutas no funcionan**:
   - Verificar configuración de Apache
   - Comprobar archivo .htaccess si existe
   - Revisar FrontController.php

### Depuración

```php
// Activar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## Seguridad

### Medidas Implementadas
- Validación de datos de entrada
- Prevención de inyección SQL
- Sanitización de datos
- Manejo seguro de sesiones

### Recomendaciones
- Mantener PHP actualizado
- Usar contraseñas seguras para la base de datos
- Implementar HTTPS en producción
- Realizar respaldos regulares

## Contribuciones

### Guía para Desarrolladores
1. Fork del proyecto
2. Crear rama para nueva funcionalidad
3. Seguir estándares de codificación PHP
4. Documentar cambios
5. Enviar pull request

### Estándares de Código
- Usar PSR-4 para autoloading
- Comentarios en español
- Nombres de variables descriptivos
- Seguir patrón MVC establecido

## Licencia

Este proyecto es de uso educativo y está disponible bajo los términos establecidos por la institución educativa.

## Contacto y Soporte

- 📧 **Email:** [pablopianeloxd@gmail.com]
- 🌐 **GitHub:** [[tu-usuario-github](https://github.com/PabloPianelo)]
- 💼 **LinkedIn:** [[tu-perfil-linkedin](https://www.linkedin.com/in/pablopianeloalonso/)]


---

**Versión**: 1.0.0  
**Última actualización**: Junio 2025  
**Desarrollado para**: Desarrollo Web en Entorno Servidor (DWes)

