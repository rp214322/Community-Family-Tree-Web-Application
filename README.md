# Community Family Tree Application

A Laravel 11 + Bootstrap 5 web app for building and visualizing family trees in a community.

## Features
- User registration (Full Name, Email, Phone, City, Password)
- Dashboard with profile, add family members, and Yajra DataTable
- Add/Edit/Delete family members (no login for family members)
- Family tree visualization (Treant.js)
- Privacy: Only direct family info is fully visible

---

## Project Setup

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd family-tree-app
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install NPM Dependencies
```bash
npm install
```

### 4. Copy and Configure Environment File
```bash
cp .env.example .env
```
- Set your database credentials in `.env`:
  - `DB_DATABASE=your_db_name`
  - `DB_USERNAME=your_db_user`
  - `DB_PASSWORD=your_db_password`

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations and Seed Sample Data
```bash
php artisan migrate --seed
```

### 7. Build Frontend Assets
```bash
npm run build
```

### 8. Start the Development Server
```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Sample Login
- **Email:** alice@example.com
- **Password:** password

---

## Notes
- Family tree visualization uses Treant.js (via CDN)
- DataTables uses Yajra DataTables (server-side) and Bootstrap 5
- You can register new users and build your own family tree

---

## Troubleshooting
- If you do not see the family tree, check browser console for JS errors and ensure all CDN scripts are loaded.
- For any issues, run:
  ```bash
  php artisan migrate:fresh --seed
  npm run build
  ```
