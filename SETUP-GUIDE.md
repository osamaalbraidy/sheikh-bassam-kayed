# WordPress Setup Guide - Step by Step

## Step 1: Complete WordPress Installation (If Not Done)

1. Open **XAMPP Control Panel**
2. Start **Apache** and **MySQL** (click "Start" buttons)
3. Open your browser and go to: `http://localhost/sheikh-bassam-kayed`
4. If you see the WordPress installation screen:
   - Select language: **العربية** (Arabic) or English
   - Click "Continue"
   - Fill in:
     - Site Title: **Sheikh Bassam Kayed** (or your preferred name)
     - Username: Choose an admin username
     - Password: Use the generated one or create your own
     - Email: Your email address
   - Click **"Install WordPress"**
   - Click **"Log In"** and enter your credentials

## Step 2: Activate the Custom Theme

1. After logging in, you'll be in the **WordPress Admin Dashboard**
2. In the left sidebar, click **"Appearance"** → **"Themes"**
3. You should see **"Sheikh Bassam Kayed"** theme
4. Hover over it and click **"Activate"**
5. The theme is now active!

## Step 3: Configure Homepage Settings

1. In the left sidebar, go to **"Settings"** → **"Reading"**
2. Under **"Your homepage displays"**, make sure **"Your latest posts"** is selected
3. Click **"Save Changes"** at the bottom

## Step 4: Flush Permalinks (Important!)

1. Go to **"Settings"** → **"Permalinks"**
2. Select **"Post name"** (recommended)
3. Click **"Save Changes"** (even if nothing changed, this refreshes the URLs)

## Step 5: Verify the Homepage

1. Go to your site: `http://localhost/sheikh-bassam-kayed`
2. You should now see the custom homepage with sections:
   - جديد الموقع (Latest from Site)
   - مقالات (Articles)
   - فتاوى و أحكام (Fatwas)
   - أخبار (News)
   - وثائق وبيانات (Documents)

## Troubleshooting

### If you still see the default blog page:

1. **Check if theme is activated:**
   - Go to **Appearance** → **Themes**
   - Make sure "Sheikh Bassam Kayed" shows "Active"

2. **Clear browser cache:**
   - Press `Ctrl + F5` to hard refresh the page
   - Or clear your browser cache

3. **Check Reading Settings:**
   - Go to **Settings** → **Reading**
   - Make sure "Your latest posts" is selected (NOT "A static page")

4. **Flush permalinks again:**
   - Go to **Settings** → **Permalinks**
   - Click **"Save Changes"**

### If the theme doesn't appear in Themes:

1. Make sure the theme folder exists at: `wp-content/themes/sheikh-bassam-kayed/`
2. Check that `style.css` file exists in that folder
3. Refresh the Themes page in WordPress admin

## Next Steps After Setup

1. **Create Navigation Menu:**
   - Go to **Appearance** → **Menus**
   - Create a new menu with Arabic items
   - Assign to "Primary Menu"

2. **Create Categories:**
   - Go to **Posts** → **Categories**
   - Create: "News" (أخبار), "Audio" (صوتيات), "Video" (مرئيات)

3. **Start Adding Content:**
   - **Articles**: Go to **مقالات** → **Add New**
   - **Fatwas**: Go to **فتاوى** → **Add New**
   - **Documents**: Go to **وثائق وبيانات** → **Add New**

