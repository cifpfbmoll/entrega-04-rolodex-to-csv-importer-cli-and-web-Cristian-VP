# Rolodex Contact Importer - Importador de Contactos

Sistema de importación de contactos desde fichas físicas de Rolodex a formato CSV usando CodeIgniter 4.

---

## Resumen del Proyecto

**Aplicación CLI** para digitalizar contactos de un Rolodex físico mediante entrada interactiva por consola, guardando los datos en un archivo CSV persistente.

### Funciones Principales

1. **Importación CLI Interactiva**: Solicita datos de contacto (Nombre, Teléfono, Email) en bucle
2. **Persistencia CSV**: Guarda contactos en `writable/contacts.csv` con encabezado automático
3. **Scripts Standalone**: Importador independiente que no requiere framework completo

---

## Estructura del Proyecto

```
04-rolodex-csv/
├── contact-importer.php           # Importador CLI interactivo
├── contact-search.php             # Buscador de contactos
├── test-importer.php              # Script de prueba
├── run-command.php                # Runner alternativo
├── writable/
│   └── contacts.csv               # Base de datos CSV
├── examples/
│   └── sample-contacts.csv        # Ejemplo de formato
├── screenshoots/                  # Capturas de pantalla
│   ├── csv_result.png
│   ├── new_entry_load.png
│   ├── search_use.png
│   ├── succes_entries_added.png
│   └── total_entries_test.png
├── app/
│   ├── Commands/
│   │   └── ContactImport.php      # Comando Spark (opcional)
│   └── Config/                    # Configuración del framework
├── composer.json                  # Dependencias PHP
└── .env                           # Variables de entorno

```

---
### ** Instalación de Dependencias**

```bash
cd /home/thian/PhpstormProjects/04-rolodex-csv
composer install
composer dump-autoload -o
```

### Ejecutando el Importador Standalone**

El script `contact-importer.php` funciona de forma independiente sin necesidad del framework completo:

```bash
php contact-importer.php
```

**Interacción de ejemplo:**
![Entries de usuario simuladas](screenshoots/succes_entries_added.png)


---

### ** Verificar Archivo CSV Generado**

```bash
cat writable/contacts.csv
```

**Salida esperada:**

Contenido del archivo CSV con los contactos guardados:  
![Contenido del CSV](screenshoots/csv_result.png)

---

### ** Ejecutar Script de Prueba**

```bash
php test-importer.php
```

**Salida esperada:**
Salida completa del script de prueba:  
![Salida del test](screenshoots/total_entries_test.png)

## Estado Actual del CSV

El archivo `writable/contacts.csv` actualmente contiene **5 contactos**, incluyendo:

- Encabezado CSV (Name, Phone, Email)
- 5 contactos originales
- 2 contacto de prueba añadido por el script de testç

---

### ** Buscador de Contactos** (NUEVA FUNCIONALIDAD)
Encuentra contactos rápidamente desde la terminal.

**Uso básico:**
```bash
# Ver estadísticas e instrucciones
php contact-search.php

# Buscar por nombre
php contact-search.php TIAN
php contact-search.php entry
```

**Características:**
- ✅ Búsqueda case-insensitive (no distingue mayúsculas/minúsculas)
- ✅ Muestra resultados en tabla formateada con colores
- ✅ Estadísticas de búsqueda (contactos encontrados, líneas revisadas)
- ✅ Sugerencias si no encuentra resultados
- ✅ Sin parámetros muestra total de contactos y primeros 5 como ejemplo
- 
![Ejemplo de salida del buscador!](screenshoots/search_use.png)
