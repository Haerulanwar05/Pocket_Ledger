# AI Development Agent Instruction Blueprint

**Project Name:** PocketLedger (Final Scalable Web Application with Multi-User Support)
**Tech Stack:** PHP (Backend), MySQL via phpMyAdmin (Database), Vanilla JavaScript & Tailwind CSS v3 (Frontend).

## Core Objective

Convert the provided single-file frontend mockup into a production-ready, highly secure, modular, and scalable multi-user Full-Stack PHP web application. The core application logic must replicate the modern high-contrast Neo-Brutalist design (Off-White, Yellow, Black) and provide an authentic personal finance bookkeeping ecosystem with stateful dark mode support, user registration, and secure account switching.

---

## Technical Architecture Requirements

1. **Directory Structure & Scalability:** Do not write a monolith file. Implement an organized directory structure:
   - `/config` (Database connection parameters using PDO)
   - `/includes` (Reusable UI fragments: `header.php`, `footer.php`)
   - `/actions` (Backend PHP functional processing routines: login, register, logout, CRUD handlers)
   - `/assets` (Custom system styles and local icons)
2. **Database System:** Use MySQL relational tables engineered via phpMyAdmin. All database communications must pass strictly through PHP Data Objects (PDO) with prepared statements to mitigate SQL Injection risks.
3. **Authentication & Multi-User Session:** Create a custom session-based user authentication layer using PHP `session_start()`. Ensure data isolation so that logged-in users can only view, create, or delete their own financial records. Protect secure functional endpoints from unauthorized deep-linking.

---

## Phase-by-Phase Development Lifecycle

### Phase 1: Database Schema Engineering (Multi-User Relational Layout)

Generate an optimized SQL schema script containing definitions ready to execute inside phpMyAdmin.

1. **Table: `users`**
   - `id` (INT, Primary Key, Auto-Increment)
   - `username` (VARCHAR(50), Unique index, strict lowercase validation)
   - `password` (VARCHAR(255), hashed via PHP `password_hash()` using BCRYPT)
   - `monthly_budget_limit` (BIGINT, Default: 0) <-- UPDATED: Default is now 0
   - `created_at` (TIMESTAMP)
2. **Table: `transactions`**
   - `id` (INT, Primary Key, Auto-Increment)
   - `user_id` (INT, Foreign Key referencing `users(id)` ON DELETE CASCADE)
   - `type` (ENUM: 'Pemasukan', 'Pengeluaran')
   - `category` (VARCHAR(100))
   - `amount` (BIGINT)
   - `description` (TEXT)
   - `transaction_date` (DATE)
   - `created_at` (TIMESTAMP)

### Phase 2: Core Configuration & Secure Session Layer

1. **`config/db.php`:** Establish an encapsulated PDO connection inside a try-catch block. Set appropriate error handling attributes (`PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`, `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ`).
2. **Global Session Control:** Ensure every stateful interaction initiates securely. Build a shared utility rule that checks if `$_SESSION['user_id']` is set before rendering sensitive workspace layouts. If not, redirect to the authentication gateway.

### Phase 3: Backend Business Logic Handlers (PHP Actions)

Develop modular, isolated PHP functional scripts that process forms and output clean redirection headers or JSON arrays:

1. **`actions/auth_register.php`:** Check if the username already exists via a prepared statement. If available, hash the password using `password_hash($password, PASSWORD_BCRYPT)` and insert the new user record.
2. **`actions/auth_login.php`:** Verify credentials using prepared statements and `password_verify()`. On success, bind user properties (`id` and `username`) to `$_SESSION` globals.
3. **`actions/auth_logout.php`:** Destroy the active session (`session_destroy()`), clear session cookies, and redirect instantly to the login screen to allow clean account switching.
4. **`actions/budget_update.php`:** Live update the `monthly_budget_limit` property in the `users` table filtered strictly by the active `$_SESSION['user_id']`.
5. **`actions/transaction_create.php`:** Process new entries. Bind the `user_id` field strictly to `$_SESSION['user_id']` to preserve strict data isolation.
6. **`actions/transaction_delete.php`:** Receive a transaction primary key token ID, double-check that its `user_id` matches the active `$_SESSION['user_id']` before execution.

### Phase 4: Frontend Re-architecting & JavaScript Validation

Map the visual layout from the updated multi-account prototype into clean PHP modular views (`login.php`, `register.php`, `index.php`).

1. **Preserve Visual Style Consistency:** Maintain exact styling values derived from the reference canvas:
   - Tailwind config injection presets (`darkMode: 'class'`).
   - High-contrast Neo-Brutalist block system elements (`retro-shadow`, custom black borders).
   - Dynamic dark mode integration bound seamlessly to the document root class hierarchy.
2. **Client-Side Form Interactivity:**
   - Implement smooth UI screen switching between the Login Card and Register Card using Vanilla JS class toggles (`.hidden`).
   - Use `addEventListener('input', ...)` on the search bar and filter dropdowns to dynamically screen rows locally.
   - Fix explicit `<select>` and `<option>` inheritance bugs across web browsers by strictly controlling dark/light mode font color behaviors.

---

## Execution Guidelines

- Deliver fully documented, production-ready PHP, JS, and SQL code with no placeholder omissions.
- Organize the output clearly by directory file naming blocks so I can copy and paste the scripts directly into my environment workspace.
