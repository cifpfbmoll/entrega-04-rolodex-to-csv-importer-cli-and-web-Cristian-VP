# 📚 DESARROLLO.MD - Guía para Desarrolladores CodeIgniter 4

> **"Transformando código en soluciones, una línea a la vez"**

---

## 🎯 **Introducción al Proyecto**

Hace años las empresas trabajaban con un Rodolex que era algo así como un **bibliotecario digital** 📚. Este desarrollo ayuda a convertir las tarjetas de contacto físicas (como las de una agenda antigua) y convertirlas en un archivo digital organizado que cualquier sistema moderno pueda leer.

**Este proyecto es exactamente eso**: una herramienta que toma contactos de un Rolodex físico y los convierte en un archivo CSV (como una hoja de cálculo de Excel).

---

## 🏗️ **Arquitectura del Proyecto**

### **Analogía del Edificio 🏢**
Piensa en este proyecto como un edificio pequeño pero funcional:

```
🏢 Edificio "Importador de Contactos"
│
├── 🚪 Entrada Principal (contact-importer.php)
│   └── Donde los usuarios entran y usan la herramienta
│
├── 📁 Almacén de Datos (writable/)
│   └── Donde guardamos todos los contactos
│
├── 📋 Planos y Documentos (documentación .md)
│   └── Guías para entender y mantener el edificio
│
└── 🔧 Herramientas (archivos de configuración)
    └── Utilidades para que todo funcione
```

---

## 📁 **Estructura del Proyecto Explicada**

```
rolodex/                          📁 La carpeta raíz (terreno del edificio)
│
├── contact-importer.php          ⭐ LA APLICACIÓN PRINCIPAL
│   └── Como la puerta principal de tu casa
│
├── writable/                     📁 Almacén de datos (como la bodega)
│   ├── .gitkeep                  📄 Marcador de posición
│   └── contacts.csv              📄 Donde se guardan los contactos
│
├── app/                          📁 Código original (como los planos del arquitecto)
│   └── Commands/                 📁 Comandos de CodeIgniter
│
├── public/                       📁 Acceso web (como la recepción)
│   └── index.php                 📄 Punto de entrada web
│
├── vendor/                       📁 Herramientas externas (como el taller de herramientas)
│   └── [dependencias de Composer]
│
└── 📄 Documentación (.md files)  📚 Manuales de instrucción
```

---

## 💻 **Código Fuente Comentado**

### **contact-importer.php - El Corazón de la Aplicación**

```php
#!/usr/bin/env php
<?php

/**
 * 🎯 IMPORTADOR DE CONTACTOS STANDALONE
 * 
 * Imagina que esto es como un camarero en un restaurante:
 * - Te pregunta qué quieres (nombre, teléfono, email)
 * - Anota todo en su libreta (archivo CSV)
 * - Te confirma que lo ha anotado bien
 */

// === ZONA DE PREPARACIÓN ===
// Como preparar la cocina antes de abrir el restaurante
define('ROOTPATH', __DIR__ . '/');        // 📍 Dónde estamos
define('WRITEPATH', __DIR__ . '/writable/'); // 📁 Dónde guardamos los datos

// Creamos la "bodega" si no existe
if (!is_dir(WRITEPATH)) {
    mkdir(WRITEPATH, 0755, true);
}

/**
 * 📝 CLASE SimpleCLI - El "Camarero Digital"
 * 
 * Esta clase es como el camarero que:
 * - Te habla (write)
 * - Te hace preguntas (prompt)
 * - Te da malas noticias (error)
 * - Hace pausas (newLine)
 */
class SimpleCLI
{
    // 💬 Hablar con el cliente
    public static function write($text, $color = null)
    {
        echo $text . PHP_EOL;  // Mostrar texto y saltar línea
    }

    // ❓ Hacer una pregunta
    public static function prompt($text)
    {
        echo $text . ': ';      // Mostrar pregunta
        return trim(fgets(STDIN)); // Esperar respuesta y quitar espacios
    }

    // ❌ Dar malas noticias
    public static function error($text)
    {
        echo 'ERROR: ' . $text . PHP_EOL;
    }

    // ⏸️ Hacer una pausa
    public static function newLine()
    {
        echo PHP_EOL;  // Solo saltar línea
    }
}

/**
 * 🏭 CLASE ContactImporter - La "Fábrica de Contactos"
 * 
 * Piensa en esta clase como una fábrica que:
 * 1. Prepara las cajas (inicializa CSV)
 * 2. Recibe los materiales (pide datos)
 * 3. Empaqueta los productos (guarda en CSV)
 * 4. Lleva un contador (cuenta contactos)
 */
class ContactImporter
{
    private $csvFilePath;  // 📁 Dónde guardamos el archivo CSV

    // 🏭 Constructor: Cuando la fábrica abre por primera vez
    public function __construct()
    {
        $this->csvFilePath = WRITEPATH . 'contacts.csv';
    }

    // 🚀 Método principal: ¡La fábrica empieza a trabajar!
    public function run()
    {
        // === BIENVENIDA ===
        // Como cuando entras a una tienda y te saludan
        SimpleCLI::write('===========================================', 'green');
        SimpleCLI::write('  Rolodex Contact Importer', 'green');
        SimpleCLI::write('===========================================', 'green');
        SimpleCLI::newLine();
        SimpleCLI::write('Enter contact information from your physical Rolodex.');
        SimpleCLI::write('Type "exit" or "quit" at the Name prompt to finish.');
        SimpleCLI::newLine();

        // Preparamos las "cajas" para guardar los contactos
        $this->initializeCsvFile();

        // === CICLO PRINCIPAL ===
        // Como una línea de montaje que nunca para hasta que le dices "alto"
        $contactCount = 0;  // 📊 Contador de productos fabricados
        
        while (true) {  // 🔄 Bucle infinito (hasta que salgamos)
            SimpleCLI::write('-------------------------------------------', 'yellow');
            
            // 1️⃣ Pedimos el nombre (el ingrediente más importante)
            $name = SimpleCLI::prompt('Full Name');
            
            // 🚪 ¿Quieres salir de la fábrica?
            if (strtolower(trim($name)) === 'exit' || strtolower(trim($name)) === 'quit') {
                SimpleCLI::newLine();
                SimpleCLI::write("Import session completed. Total contacts added: {$contactCount}", 'green');
                SimpleCLI::write("CSV file location: {$this->csvFilePath}", 'cyan');
                break;  // 🛑 Salir del bucle
            }

            // ❌ ¿Nombre vacío? No podemos fabricar sin nombre
            if (empty(trim($name))) {
                SimpleCLI::error('Name cannot be empty. Please try again or type "exit" to quit.');
                SimpleCLI::newLine();
                continue;  // 🔄 Volver a empezar el bucle
            }

            // 2️⃣ Pedimos los otros ingredientes
            $phone = SimpleCLI::prompt('Phone Number');
            $email = SimpleCLI::prompt('Email Address');

            // 3️⃣ Empaquetamos el producto
            if ($this->appendContactToCsv($name, $phone, $email)) {
                $contactCount++;  // 📊 Un producto más en el contador
                SimpleCLI::write("✓ Contact saved successfully!", 'green');
            } else {
                SimpleCLI::error("✗ Failed to save contact. Please try again.");
            }

            SimpleCLI::newLine();
        }
    }

    /**
     * 📦 initializeCsvFile() - Preparar las cajas
     * 
     * Como cuando abres una nueva fábrica y necesitas:
     * - Crear el almacén (directorio)
     * - Poner etiquetas a las cajas (cabecera CSV)
     */
    private function initializeCsvFile(): void
    {
        // ¿Existe el almacén y tiene algo dentro?
        if (!file_exists($this->csvFilePath) || filesize($this->csvFilePath) === 0) {
            
            // Creamos el almacén si no existe
            $directory = dirname($this->csvFilePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);  // 📁 Crear directorio con permisos
            }

            // Ponemos las etiquetas a las cajas (cabecera CSV)
            $file = fopen($this->csvFilePath, 'w');  // 📝 Abrir archivo para escribir
            if ($file !== false) {
                fputcsv($file, ['Name', 'Phone', 'Email']);  // 📋 Escribir cabecera
                fclose($file);  // 🔒 Cerrar archivo
                SimpleCLI::write("CSV file initialized: {$this->csvFilePath}", 'cyan');
                SimpleCLI::newLine();
            } else {
                SimpleCLI::error("Failed to initialize CSV file at: {$this->csvFilePath}");
                SimpleCLI::newLine();
            }
        } else {
            // El almacén ya existe y tiene cuestas etiquetadas
            SimpleCLI::write("Using existing CSV file: {$this->csvFilePath}", 'cyan');
            SimpleCLI::newLine();
        }
    }

    /**
     * 📦 appendContactToCsv() - Empaquetar un contacto
     * 
     * Como tomar los ingredientes y ponerlos en una caja bonita:
     * - Abrir la caja (archivo)
     * - Poner los ingredientes (datos)
     * - Cerrar la caja (guardar)
     */
    private function appendContactToCsv(string $name, string $phone, string $email): bool
    {
        // Abrimos la caja para añadir más cosas (modo append)
        $file = fopen($this->csvFilePath, 'a');
        
        if ($file === false) {
            return false;  // ❌ No pudimos abrir la caja
        }

        // Metemos los ingredientes en la caja, bien ordenados
        $result = fputcsv($file, [
            trim($name),   // 🏷️ Nombre sin espacios extra
            trim($phone),  // 📞 Teléfono sin espacios extra
            trim($email)   // 📧 Email sin espacios extra
        ]);

        fclose($file);  // 🔒 Cerramos la caja

        return $result !== false;  // ✅ ¿Se guardó bien?
    }
}

// === ARRANCAR LA FÁBRICA ===
// Como darle al botón de "ON" en la fábrica
$importer = new ContactImporter();
$importer->run();
```

---

## 🔧 **Conceptos Técnicos Explicados**

### **1. PHP CLI (Command Line Interface) 🖥️**
**Analogía**: Es como hablar con tu programa en lugar de hacer clic en botones.

```php
// En lugar de un formulario web:
<input type="text" name="name">

// Usamos la línea de comando:
$name = SimpleCLI::prompt('Full Name');
```

### **2. Manejo de Archivos CSV 📊**
**Analogía**: Es como una hoja de cálculo donde cada fila es un contacto y cada columna es un dato.

```php
// CSV es como esto:
// Nombre    , Teléfono    , Email
// Juan Pérez, 555-1234    , juan@email.com

// En código PHP:
fputcsv($file, ['Juan Pérez', '555-1234', 'juan@email.com']);
```

### **3. Bucles y Control de Flujo 🔄**
**Analogía**: Es como una línea de ensamblaje que sigue trabajando hasta que le dices "pare".

```php
while (true) {  // 🔄 Seguir trabajando...
    // ...hacer trabajo...
    
    if ($user_wants_to_exit) {
        break;  // 🛑 ¡Alto! Terminar de trabajar
    }
}
```

---

## 🎓 **Guía para Desarrolladores Novatos CodeIgniter 4**

### **¿Qué es CodeIgniter 4?**
**Analogía**: Es como un juego de LEGO para construir sitios web. Te da piezas prefabricadas para que no tengas que construir todo desde cero.

### **¿Por qué no usamos CodeIgniter aquí?**
- **Simplicidad**: Para esta tarea, es como usar una taladradora industrial para colgar un cuadro
- **Independencia**: No queremos depender de muchas piezas externas
- **Velocidad**: Arrancamos más rápido sin el framework

### **Conceptos CodeIgniter que verás en otros proyectos:**

#### **📁 Estructura MVC (Model-View-Controller)**
```
🏢 Edificio MVC:
├── 🏛️ Model (Base de datos) - Donde vive la información
├── 🎮 Controller (Lógica) - El cerebro que piensa
└── 🎨 View (Interfaz) - Lo que ve el usuario
```

#### **🔧 Autoloading y Namespaces**
```php
// En CodeIgniter 4:
namespace App\Commands;  // 📁 Dónde vive este código
use CodeIgniter\CLI\CLI;  // 🔧 Herramientas que usamos
```

#### **📦 Composer (Gestor de Paquetes)**
**Analogía**: Es como una tienda de LEGO donde puedes comprar piezas adicionales.

```bash
composer require codeigniter4/framework  # 🛒 Comprar el framework
```

---

## 🚀 ** Debes extender, como mínimo, estos 3 niveles de este Proyecto**

### **Nivel 1: Modificaciones Simples**
```php
// Añadir más campos:
$company = SimpleCLI::prompt('Company');

// Guardar más datos:
fputcsv($file, [$name, $phone, $email, $company]);
```

### **Nivel 2: Validación de Datos**
```php
// Validar email:
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    SimpleCLI::error('Invalid email format!');
    continue;
}
```

### **Nivel 3: Integración con bases de datos y CodeIgniter 4**
```php
// Usar la clase Database de CI4:
$db = \Config\Database::connect();
$db->table('contacts')->insert($data);
```

### **Nivel 4: Versión Web Simple con CodeIgniter 4**
**Analogía**: Convertir nuestro script de línea de comandos en una pequeña página web donde puedas:
- 🌐 **Ver tus contactos** en una tabla bonita
- ➕ **Añadir contactos** con un formulario
- 📥 **Exportar a CSV** con un botón
- 🗑️ **Eliminar contactos** fácilmente

```php
// === CONTROLLER SIMPLE (app/Controllers/Contacts.php) ===
<?php
namespace App\Controllers;

class Contacts extends BaseController
{
    // 📋 Mostrar todos los contactos
    public function index()
    {
        // Leer el archivo CSV
        $csvFile = WRITEPATH . 'contacts.csv';
        $contacts = [];
        
        if (file_exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            if ($handle) {
                // Saltar la cabecera
                fgetcsv($handle);
                
                // Leer todos los contactos
                while (($row = fgetcsv($handle)) !== false) {
                    $contacts[] = [
                        'name' => $row[0] ?? '',
                        'phone' => $row[1] ?? '',
                        'email' => $row[2] ?? ''
                    ];
                }
                fclose($handle);
            }
        }
        
        return view('contacts/index', ['contacts' => $contacts]);
    }
    
    // ➕ Formulario para añadir contacto
    public function create()
    {
        return view('contacts/create');
    }
    
    // 💾 Guardar nuevo contacto
    public function store()
    {
        // Validar datos simples
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        
        if (empty(trim($name))) {
            return redirect()->back()->with('error', 'El nombre es requerido');
        }
        
        // Validar email si se proporciona
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email inválido');
        }
        
        // Añadir al CSV (igual que nuestro script original)
        $csvFile = WRITEPATH . 'contacts.csv';
        
        // Crear archivo si no existe
        if (!file_exists($csvFile)) {
            $handle = fopen($csvFile, 'w');
            fputcsv($handle, ['Name', 'Phone', 'Email']);
            fclose($handle);
        }
        
        // Añadir nuevo contacto
        $handle = fopen($csvFile, 'a');
        fputcsv($handle, [trim($name), trim($phone), trim($email)]);
        fclose($handle);
        
        return redirect()->to('/contacts')->with('success', '¡Contacto añadido!');
    }
    
    // 📥 Exportar a CSV
    public function export()
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        
        if (!file_exists($csvFile)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        // Descargar el archivo
        return $this->response->download($csvFile, null);
    }
}

// === VIEW PARA VER CONTACTOS (app/Views/contacts/index.php) ===
<!DOCTYPE html>
<html>
<head>
    <title>📇 Mis Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 800px; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📇 Mis Contactos</h1>
            <div>
                <a href="/contacts/create" class="btn btn-primary">➕ Añadir Contacto</a>
                <a href="/contacts/export" class="btn btn-success">📥 Exportar CSV</a>
            </div>
        </div>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <?php if (empty($contacts)): ?>
                    <p class="text-center text-muted">No hay contactos todavía. 
                       <a href="/contacts/create">Añade tu primer contacto</a>.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?= esc($contact['name']) ?></td>
                                    <td><?= esc($contact['phone']) ?></td>
                                    <td><?= esc($contact['email']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mt-3">
                        Total: <?= count($contacts) ?> contacto(s)
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-muted">
                💡 Tip: También puedes usar la línea de comandos con 
                <code>php contact-importer.php</code>
            </small>
        </div>
    </div>
</body>
</html>

// === VIEW PARA AÑADIR CONTACTO (app/Views/contacts/create.php) ===
<!DOCTYPE html>
<html>
<head>
    <title>➕ Añadir Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>➕ Añadir Nuevo Contacto</h4>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="/contacts/store">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name') ?>" required>
                        <small class="text-muted">El nombre es obligatorio</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?= old('phone') ?>" placeholder="555-123-4567">
                        <small class="text-muted">Opcional</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>" placeholder="email@ejemplo.com">
                        <small class="text-muted">Opcional</small>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/contacts" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">💾 Guardar Contacto</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="/contacts" class="btn btn-link">← Volver a la lista</a>
        </div>
    </div>
</body>
</html>
```

### **¿Qué incluye el Nivel 4 Simplificado?**

🌐 **Interfaz Web Básica**
- **Lista de contactos**: Tabla bonita y ordenada
- **Formulario simple**: Campos para nombre, teléfono, email
- **Validación básica**: Nombre requerido, email válido
- **Exportación CSV**: Botón para descargar datos

📁 **Misma Lógica CSV**
- **No usa base de datos**: Sigue usando el archivo CSV
- **Compatible con CLI**: Puedes usar ambos métodos
- **Mismo formato**: Compatible con tu aplicación actual

🎨 **Diseño Moderno**
- **Bootstrap**: Interfaz limpia y responsive
- **Bootstrap Icons**: Iconos visuales
- **Colores y estilos**: Agradable a la vista

### **Configuración de Rutas (app/Config/Routes.php)**
```php
// Añadir estas rutas al final del archivo
$routes->get('/contacts', 'Contacts::index');
$routes->get('/contacts/create', 'Contacts::create');
$routes->post('/contacts/store', 'Contacts::store');
$routes->get('/contacts/export', 'Contacts::export');
```

### **Comandos para el Nivel 4 Simplificado:**
```bash
# Iniciar servidor de desarrollo
php spark serve

# Acceder a la aplicación
# Abre tu navegador en: http://localhost:8080/contacts
```

### **Ventajas del Nivel 4 Simplificado:**
- 🎯 **Fácil de entender**: Usa la misma lógica CSV
- 🌐 **Acceso web**: Usa desde cualquier navegador
- 📱 **Responsive**: Funciona en móviles
- 🔄 **Compatible**: No rompe tu aplicación actual
- 🚀 **Rápido de implementar**: Menos de 1 hora

---

## 🔍 **Flujo de Datos Completo**

```
👤 Usuario
    │
    ▼ (escribe datos)
🖥️ Línea de Comando
    │
    ▼ (captura entrada)
💻 contact-importer.php
    │
    ▼ (procesa y valida)
📝 Archivo CSV
    │
    ▼ (guarda permanentemente)
💾 writable/contacts.csv
    │
    ▼ (puede ser importado)
📊 Google Contacts / Outlook / Excel
```

---

## 🛠️ **Herramientas de Desarrollo**

### **Para probar el código:**
```bash
# Ejecutar la aplicación
php contact-importer.php

# Ver los datos guardados
cat writable/contacts.csv

# Contar contactos
wc -l writable/contacts.csv
```

### **Para depurar errores:**
```bash
# Ver errores de PHP
php -l contact-importer.php

# Ejecutar con errores visibles
php -d display_errors=1 contact-importer.php
```

---

## 📈 **Próximos Pasos para el Desarrollador**

1. **📚 Estudiar PHP CLI**: Aprende a hacer programas de línea de comandos
2. **🔧 Aprender Composer**: Gestiona dependencias como un profesional
3. **🏗️ Explorar CodeIgniter 4**: Cuando necesites construir aplicaciones más grandes
4. **📊 Dominar CSV**: Formato universal para intercambio de datos
5. **🛡️ Aprender Validación**: Protege tus datos de entrada incorrecta

---

## 🎯 **Resumen**

**Este proyecto es tu primer paso en el mundo del desarrollo PHP:**
- ✅ **Real y útil**: Resuelve un problema real
- ✅ **Simple pero completo**: Tiene todos los componentes básicos
- ✅ **Bien documentado**: Cada línea tiene su propósito
- ✅ **Extensible**: Puedes hacerlo más complejo cuando estés listo

**Lo que has aprendido:**
- 🖥️ Programación CLI en PHP
- 📁 Manejo de archivos y directorios
- 📊 Formato CSV y manejo de datos
- 🔄 Control de flujo y bucles
- 🏗️ Estructura de proyectos
- 📝 Comentarios y documentación

---

**🔗 Recursos recomendados:**
- [PHP Manual](https://www.php.net/docs.php)
- [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)
- [Composer Documentation](https://getcomposer.org/doc/)

---

*Creado con ❤️ para desarrolladores que empiezan su viaje en CodeIgniter 4*
