# Community Family Tree Application

## Overview
This is a Laravel 11 + Bootstrap 5 web application for managing and visualizing family trees in a community. Each user can register, add family members, and view their family hierarchy. The app also supports a community-wide tree view with privacy controls.

## Features
- **User Registration:** Register with name, email, phone, city, and password.
- **Dashboard:**
  - View your profile info in a grid.
  - Add family members (child, spouse, sibling, etc.) using a DataTable.
  - See your family tree as a hierarchy (full info for you and your direct family).
  - **Community Family Trees:** See all other users' family trees below your own, with only name and city visible for privacy.
- **Family Tree Visualization:**
  - Uses Treant.js for interactive tree diagrams.
  - Hierarchical view starts from the logged-in user (on dashboard) or from all users (on community tree page).
- **Privacy Controls:**
  - You and your direct family: full info (name, city, phone, email).
  - Extended family: masked contact info.
  - Other users and their families: only name and city are shown.
- **Permissions:**
  - You can only edit/delete your own family members.
  - You cannot view private info of other users' family members.

## Community Tree View
- Visit `/community-tree` to see the full community tree (all users and their families), with privacy masking.
- Each user's tree is also shown on your dashboard, below your own tree, with only name and city for privacy.

## Setup Instructions
1. **Clone the repository**
2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Configure your `.env` file** for database and mail settings.
4. **Run migrations and seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Start the server:**
   ```bash
   php artisan serve
   ```
6. **Login/Register** and explore the dashboard and community tree features.

## Tech Stack
- Laravel 11
- Bootstrap 5
- Treant.js (for tree visualization)
- MySQL (or compatible database)

## Notes
- The dashboard and community tree both enforce privacy as described above.
- You can only manage (add/edit/delete) your own family members.

---
For any questions or issues, please open an issue or contact the maintainer.
