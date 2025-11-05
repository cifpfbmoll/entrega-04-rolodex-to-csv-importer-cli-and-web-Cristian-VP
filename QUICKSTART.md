# Quick Start Guide - Rolodex Contact Importer

Get up and running in under 5 minutes!

## 🚀 Fastest Setup (Existing CI4 Project)

If you already have CodeIgniter 4 installed:

```bash
# 1. Copy the command file to your project
cp app/Commands/ContactImport.php /path/to/your-ci4-project/app/Commands/

# 2. Navigate to your CI4 project
cd /path/to/your-ci4-project

# 3. Run the command
php spark import:contacts
```

**Done!** Start entering contacts.

---

## 🆕 Fresh Installation (No CI4 Yet)

Starting from scratch? Follow these steps:

### Step 1: Install CodeIgniter 4

```bash
# Install via Composer (recommended)
composer create-project codeigniter4/appstarter rolodex

# Navigate to project
cd rolodex
```

### Step 2: The Command File

The command file is already created at:
```
app/Commands/ContactImport.php
```

If you need to copy it:
```bash
cp /path/to/ContactImport.php app/Commands/
```

### Step 3: Run It!

```bash
php spark import:contacts
```

---

## 📝 Your First Contact Entry

When you run the command, you'll see:

```
===========================================
  Rolodex Contact Importer
===========================================

Enter contact information from your physical Rolodex.
Type "exit" or "quit" at the Name prompt to finish.

CSV file initialized: writable/contacts.csv

-------------------------------------------
Full Name: _
```

**Enter your first contact:**
1. Type the full name: `John Smith`
2. Press Enter
3. Type the phone: `555-123-4567`
4. Press Enter
5. Type the email: `john@example.com`
6. Press Enter

You'll see:
```
✓ Contact saved successfully!
```

**Add more contacts** or type `exit` at the Name prompt to finish.

---

## 🔍 Verify Your Data

After exiting, check your CSV file:

```bash
# View the CSV
cat writable/contacts.csv

# Or open in a spreadsheet
# Linux: libreoffice writable/contacts.csv
# Mac: open writable/contacts.csv
# Windows: start writable/contacts.csv
```

You should see:
```csv
Name,Phone,Email
John Smith,555-123-4567,john@example.com
```

---

## ⚡ Command Reference

### Run the Importer
```bash
php spark import:contacts
```

### Check Available Commands
```bash
php spark list
```

### View Command Help
```bash
php spark help import:contacts
```

---

## 🎯 Tips & Tricks

### Exit Quickly
Type `exit` or `quit` when prompted for a name.

### Empty Fields
Phone and Email can be left empty (just press Enter), but Name is required.

### Multiple Sessions
Run the command multiple times - new contacts will be appended to the existing CSV.

### Backup Your Data
```bash
# Create a backup before each session
cp writable/contacts.csv writable/contacts-backup-$(date +%Y%m%d).csv
```

### View Contact Count
```bash
# Count contacts (subtract 1 for header)
wc -l writable/contacts.csv
```

---

## 🐛 Troubleshooting

### "Command not found"
✅ **Solution**: Ensure `ContactImport.php` is in `app/Commands/` directory

### "Permission denied" when writing CSV
✅ **Solution**: 
```bash
chmod -R 755 writable/
# Or if that doesn't work:
chmod -R 777 writable/
```

### CSV file not created
✅ **Solution**: Check that the `writable/` directory exists:
```bash
mkdir -p writable
chmod 755 writable
```

### "Class not found" error
✅ **Solution**: Make sure you're in the CodeIgniter project root directory

---

## 📊 Example Session

Here's a complete example session:

```bash
$ php spark import:contacts

===========================================
  Rolodex Contact Importer
===========================================

Enter contact information from your physical Rolodex.
Type "exit" or "quit" at the Name prompt to finish.

CSV file initialized: /home/user/project/writable/contacts.csv

-------------------------------------------
Full Name: Victor Frankenstein
Phone Number: 555-776-2323
Email Address: doctor@nodedojo.com
✓ Contact saved successfully!

-------------------------------------------
Full Name: Jane Smith
Phone Number: 555-123-4567
Email Address: jane.smith@example.com
✓ Contact saved successfully!

-------------------------------------------
Full Name: Bob Johnson
Phone Number: 555-999-8888
Email Address: bob@company.com
✓ Contact saved successfully!

-------------------------------------------
Full Name: exit

Import session completed. Total contacts added: 3
CSV file location: /home/user/project/writable/contacts.csv
```

---

## 📥 Import to Other Systems

### Import to Google Contacts
1. Go to Google Contacts (contacts.google.com)
2. Click "Import"
3. Select your `contacts.csv` file
4. Map columns: Name → Name, Phone → Phone, Email → Email

### Import to Outlook
1. Open Outlook
2. File → Open & Export → Import/Export
3. Choose "Import from another program or file"
4. Select "Comma Separated Values"
5. Browse to `contacts.csv`

### Import to Excel/LibreOffice
Simply open the CSV file in your spreadsheet application.

---

## ✅ Next Steps

- [ ] Run your first import session
- [ ] Verify CSV file is created
- [ ] Add multiple contacts
- [ ] Import CSV to your contact management system
- [ ] Create a backup routine

---

**Need help?** Check the full README.md and FEATURES.md for detailed documentation.

**Ready to start?** Run: `php spark import:contacts`

🎉 **Happy Importing!**
