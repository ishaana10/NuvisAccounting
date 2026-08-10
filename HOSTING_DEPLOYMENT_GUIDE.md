# NuvisAccounting™ Hosting Deployment Guide

This guide details the current state of this repository, fixes already applied to make it working, server requirements, and step-by-step instructions to successfully deploy and test NuvisAccounting on your hosting.

---

## 🛠️ Fixes Applied in This Repository Copy

To make this repository a fully working copy ready for testing and easy deployment, the following changes have been completed:

1. **Restored Missing `public/money.json`:**
   - The original repository copy was missing `public/money.json`, which caused any frontend assets compilation to fail with module resolution errors.
   - We fetched and restored the correct schema for `money.json` into the `public/` directory.

2. **Compiled Production Assets Pre-Bundled:**
   - Compiling frontend assets on shared hosting or testing servers is often difficult or impossible due to Node.js/npm version limitations or memory restrictions.
   - We have successfully run Laravel Mix (`npm run prod`) to compile all Vue components and Tailwind styles.
   - The compiled files under `public/js/`, `public/css/`, and `public/mix-manifest.json` have been **force-committed** to this repository.
   - **Result:** You do **NOT** need Node.js, `npm`, or webpack on your hosting server. The application is completely ready to serve production assets out-of-the-box!

---

## 🛡️ Resolving GitHub Actions / CI Failures

Because several composer dependencies are private GitHub repositories under the `nuvisaccounting/` namespace, standard GitHub Actions CI/CD runs will fail with **404 Not Found** errors when attempting to download those archives.

We have updated the CI workflow (`.github/workflows/tests.yml`) to support custom authentication via repository secrets. To make your CI pass on GitHub:

1. Create a **GitHub Personal Access Token (PAT)** from your GitHub settings with `repo` read permissions.
2. Go to your repository on GitHub.
3. Click on **Settings** -> **Secrets and variables** -> **Actions**.
4. Click on **New repository secret**.
5. Set Name to `COMPOSER_TOKEN`.
6. Set Secret to your generated GitHub PAT.
7. Re-run your workflow. The setup script will automatically inject this token so `composer install` can successfully authenticate and pull the private packages!

---

## 📋 System Requirements

Ensure your hosting environment meets the following baseline requirements:

* **PHP:** Version `8.1` or higher (PHP 8.2 or 8.3 are recommended).
* **PHP Extensions Required:**
  - `ext-bcmath`
  - `ext-ctype`
  - `ext-curl`
  - `ext-dom`
  - `ext-fileinfo`
  - `ext-gd`
  - `ext-intl`
  - `ext-json`
  - `ext-mbstring`
  - `ext-openssl`
  - `ext-tokenizer`
  - `ext-xml`
  - `ext-zip`
* **Database:** MySQL 5.7+ / MariaDB 10.3+, PostgreSQL, SQLite, or SQL Server.
* **Web Server:** Apache (with `mod_rewrite` enabled) or Nginx.

---

## 🚀 Step-by-Step Deployment Instructions

### Step 1: Upload the Code to Your Server
Upload the entire repository files to your hosting server via Git clone, SSH, or FTP.

> **Crucial Web Root Configuration:**
> For security and proper asset routing, your domain or subdomain must point directly to the **`public/`** folder as its document root (not the project root directory).
> - **Apache:** Ensure `.htaccess` inside the `public/` folder is active and `mod_rewrite` is enabled.
> - **Nginx:** Configure your server block to point to `/path/to/nuvisaccounting/public` and include standard Laravel routing config. See the included `nginx.example.com.conf` for reference.

---

### Step 2: Configure File & Folder Permissions
The web server needs write access to the following directories for session files, caching, logging, and uploads:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
*(If on cPanel/Shared hosting, ensure the owner of the files matches the web server user, usually set automatically upon upload).*

---

### Step 3: Install PHP Dependencies (Composer)

Several critical dependencies (such as the module manager and payment integrations under the `nuvisaccounting/` namespace) reside in private repositories.

#### A. If using a VPS / Dedicated Server (with SSH/CLI Access):
1. Create a **GitHub Personal Access Token (PAT)** with repository read permissions from your GitHub account.
2. Authenticate Composer with your GitHub token globally on your server:
   ```bash
   composer config -g github-oauth.github.com <YOUR_GITHUB_PERSONAL_ACCESS_TOKEN>
   ```
3. Install the dependencies:
   ```bash
   composer install --no-dev --prefer-dist --optimize-autoloader
   ```

#### B. If using Shared Hosting (without SSH/CLI Access):
If your hosting does not have CLI access or PHP Composer installed:
1. Run `composer install --no-dev --prefer-dist --optimize-autoloader` locally or on a development environment (first configuring your GitHub token as mentioned above).
2. Once the `vendor/` directory is fully installed, archive (zip) the entire project directory including the `vendor/` folder.
3. Upload the zip file to your shared hosting and extract it.

---

### Step 4: Environment & Database Configuration (`.env`)
1. Duplicate `.env.example` and name the copy `.env`:
   ```bash
   cp .env.example .env
   ```
2. Open `.env` and fill in your database credentials:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
3. Set your Application URL:
   ```ini
   APP_URL=https://your-domain.com
   ```
4. Generate the Application Encryption Key:
   ```bash
   php artisan key:generate
   ```
   *(If you don't have SSH/CLI, run `php artisan key:generate` locally first and copy the generated `APP_KEY` value into your server's `.env` file).*

---

### Step 5: Run the Installer

You can install NuvisAccounting using either the CLI or the built-in web installer.

#### Option A: CLI Installation (Recommended)
Run the following artisan command from the project root:
```bash
php artisan install --db-name="your_database_name" --db-username="your_database_user" --db-password="your_database_password" --admin-email="admin@yourdomain.com" --admin-password="your_secure_password"
```

#### Option B: Web Installer (Wizard)
Simply visit your domain URL (e.g. `https://your-domain.com`) in your web browser.
Since `APP_INSTALLED` is set to `false` in `.env`, you will be automatically redirected to the visual web wizard installer. Follow the step-by-step instructions:
1. Requirements & Permissions check.
2. Database configuration.
3. Administrative account creation.

Once completed, the system will update `.env` setting `APP_INSTALLED=true`.

---

### Step 6: Configure the Task Scheduler (Cron Job)
NuvisAccounting utilizes Laravel's scheduler to handle automated recurring invoices, bill reminders, and email queueing.

Add the following single cron entry to your server or cPanel Cron Jobs section to run **every minute**:
```cron
* * * * * cd /path/to/your/nuvisaccounting && php artisan schedule:run >> /dev/null 2>&1
```
*(Be sure to replace `/path/to/your/nuvisaccounting` with the absolute path of your installation).*

---

## 🔍 Troubleshooting FAQ

* **Issue: "500 Internal Server Error" or Blank Page**
  - **Check 1:** Ensure file permissions on `storage` and `bootstrap/cache` are writable.
  - **Check 2:** Look at the error logs inside `storage/logs/laravel.log` or your web server's logs.
  - **Check 3:** Verify that your domain points directly to the `public/` directory.

* **Issue: "Composer install fails with 404 or Authentication timeout"**
  - Make sure you configured the GitHub Personal Access Token correctly. Composer requires authentication to download the private repositories listed in `composer.json` under the `nuvisaccounting/` namespace.

* **Issue: "Database Connection Refused"**
  - Confirm that your hosting database user has full privileges (GRANT ALL) on the created database and check that the `DB_HOST` in `.env` matches your hosting provider's DB host (often `localhost` or `127.0.0.1`).
