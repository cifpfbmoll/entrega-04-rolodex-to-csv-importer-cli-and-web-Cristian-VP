# Quick Setup Guide

## Option 1: Add to Existing CodeIgniter 4 Project

If you already have a CodeIgniter 4 project:

1. Copy the command file:
   ```bash
   cp app/Commands/ContactImport.php /path/to/your/ci4-project/app/Commands/
   ```

2. Run the command:
   ```bash
   cd /path/to/your/ci4-project
   php spark import:contacts
   ```

## Option 2: Fresh CodeIgniter 4 Installation

If you're starting from scratch:

### Step 1: Install CodeIgniter 4 via Composer

```bash
# Install CodeIgniter 4
composer create-project codeigniter4/appstarter rolodex

# Navigate to project
cd rolodex
```

### Step 2: Copy the Command File

```bash
# The command file should be at:
# app/Commands/ContactImport.php
```

### Step 3: Set Permissions

```bash
# Ensure writable directory has proper permissions
chmod -R 755 writable/
```

### Step 4: Run the Command

```bash
php spark import:contacts
```

## Option 3: Minimal Setup (For Testing)

If you want to test the command without a full CI4 installation:

### Required Files

You'll need these minimum CodeIgniter 4 files:
- `spark` (CLI entry point)
- `app/Config/Paths.php`
- `app/Config/Constants.php`
- `system/` directory (CodeIgniter 4 system files)
- `vendor/` directory (Composer dependencies)

### Quick Install

```bash
# Install via Composer
composer require codeigniter4/framework

# Create directory structure
mkdir -p app/Commands writable

# Copy the ContactImport.php to app/Commands/

# Run
php spark import:contacts
```

## Verification

After setup, verify the command is available:

```bash
php spark list
```

You should see `import:contacts` under the "Import" group.

## Troubleshooting

### Command Not Found

If you get "Command not found":
1. Ensure `ContactImport.php` is in `app/Commands/`
2. Check the namespace is `App\Commands`
3. Verify the file has proper PHP opening tag

### Permission Denied

If you get permission errors:
```bash
chmod -R 755 writable/
# Or if that doesn't work:
chmod -R 777 writable/
```

### CSV File Not Created

If the CSV file isn't created:
1. Check `writable/` directory exists
2. Verify write permissions on `writable/`
3. Check PHP error logs for details

## Testing

Test the command with sample data:

```bash
php spark import:contacts
```

Then enter:
- **Name**: Test Contact
- **Phone**: 555-0000
- **Email**: test@example.com
- **Name**: exit (to quit)

Check the output file:
```bash
cat writable/contacts.csv
```

You should see:
```
Name,Phone,Email
Test Contact,555-0000,test@example.com
```

## Next Steps

Once setup is complete:
1. Run the command: `php spark import:contacts`
2. Enter your contact data
3. Find the CSV at `writable/contacts.csv`
4. Import the CSV into your preferred contact management system
