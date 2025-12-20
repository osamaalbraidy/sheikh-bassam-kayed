# How to Set Upload Limit to 100MB on Production Server

## Method 1: .htaccess (Already Added)
✅ **Already configured in your `.htaccess` file**

This works on most shared hosting providers (cPanel, etc.). The settings are already in your `.htaccess` file.

**Note:** Some hosts disable `php_value` in `.htaccess`. If this doesn't work, try Method 2.

---

## Method 2: .user.ini File (Already Created)
✅ **Already created in your root directory**

Upload the `.user.ini` file to your server's root directory (same location as `wp-config.php`).

**Important:** After uploading `.user.ini`, you may need to wait 5-10 minutes for changes to take effect, or contact your host to clear the PHP cache.

---

## Method 3: php.ini (VPS/Dedicated Server)
If you have root/SSH access to your server:

1. Find your `php.ini` file:
   ```bash
   php --ini
   ```

2. Edit the file and change:
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   memory_limit = 256M
   max_execution_time = 300
   ```

3. Restart your web server (Apache/Nginx)

---

## Method 4: cPanel (If Available)
If your host uses cPanel:

1. Log into cPanel
2. Go to **Select PHP Version** or **MultiPHP INI Editor**
3. Click on **Options** tab
4. Find and edit:
   - `upload_max_filesize` → 100M
   - `post_max_size` → 100M
   - `memory_limit` → 256M
5. Click **Save**

---

## Method 5: WordPress wp-config.php (Alternative)
Add this to your `wp-config.php` file (before "That's all, stop editing!"):

```php
@ini_set('upload_max_filesize', '100M');
@ini_set('post_max_size', '100M');
@ini_set('memory_limit', '256M');
@ini_set('max_execution_time', '300');
```

**Note:** This only works if your host allows `ini_set()`.

---

## How to Verify It's Working

1. **Check in WordPress:**
   - Go to **WordPress Admin → Media → Add New**
   - Look at the upload limit shown at the bottom

2. **Check via PHP Info:**
   - Create a file called `phpinfo.php` in your root:
     ```php
     <?php phpinfo(); ?>
     ```
   - Visit: `yoursite.com/phpinfo.php`
   - Search for `upload_max_filesize` and `post_max_size`
   - **Delete this file after checking** (security risk!)

3. **Check via WordPress Site Health:**
   - Go to **WordPress Admin → Tools → Site Health → Info**
   - Look under **Server** section

---

## Troubleshooting

### If .htaccess doesn't work:
- Your host may have disabled `php_value` directives
- Try Method 2 (.user.ini) instead
- Or contact your hosting support

### If .user.ini doesn't work:
- Some hosts don't support `.user.ini`
- Try Method 4 (cPanel) or Method 5 (wp-config.php)
- Contact your hosting support

### If nothing works:
- Contact your hosting provider
- Ask them to increase PHP upload limits
- They may need to modify server-level `php.ini`

---

## Recommended Settings Summary

```
upload_max_filesize = 100M    (Maximum file upload size)
post_max_size = 100M          (Must be ≥ upload_max_filesize)
memory_limit = 256M           (Should be ≥ post_max_size)
max_execution_time = 300      (5 minutes for large uploads)
max_input_time = 300          (5 minutes for processing)
```

---

## Files to Upload to Server

When deploying, make sure to upload:
- ✅ `.htaccess` (with PHP settings)
- ✅ `.user.ini` (backup method)

**Security Note:** After verifying, delete `phpinfo.php` if you created it!
