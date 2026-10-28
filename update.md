# Project Update Notes - ci_siswa v1.3.0

> **For future AI chats:** Read this file first to quickly understand the current project state and avoid spending tokens rediscovering its configuration and implemented features. Verify the source files before making changes, since this note may become outdated.

## Project Summary

- **Project:** `ci_siswa`, a CodeIgniter 4 student-record web application.
- **Current project version:** `v1.3.0` (assignment/project version noted for this update).
- **Frontend:** Tailwind CSS (via CDN) and Alpine.js / Vanilla JS with a responsive collapsible sidebar layout (expand on hover or toggle, desktop 60px to 300px transition, mobile slide-in overlay drawer), paginated student list, create modal, per-student edit modals with emerald green header (`bg-emerald-600`), delete controls, and top navbar.
- **Pagination:** `Home::index()` uses CodeIgniter 4 `paginate(10)` and passes the current page and page size to the view. Row numbering continues across pages using `(($page - 1) * $perPage) + 1`.
- **Primary entry URL:** `http://localhost/ci_siswa/public/`, configured in `.env` as `app.baseURL`.
- **Web server document root:** For a standard CI4 deployment, point the web server at the project's `public/` directory.

## Database Configuration and Schema

- **Database:** `db_rpl_siswa`
- **Table:** `siswa`
- **Columns:**
  - `id` — `INT`, auto-increment, primary key
  - `nis` — `VARCHAR`
  - `nama` — `VARCHAR`
  - `kelas` — `VARCHAR`
- **Sample records:** `app/Database/Seeds/SiswaSeeder.php` provides 14 demo records (`DEMO001` through `DEMO014`). Run `php spark db:seed SiswaSeeder` from the project root after configuring the database connection. The seeder also removes only its retired demo records `DEMO015` through `DEMO020`, if present; it does not remove other student rows.
- Connection settings are read from `.env`; credentials are intentionally not repeated here.

## Registered Routes

Routes currently registered in `app/Config/Routes.php`:

| Method | Route | Handler | Purpose |
|---|---|---|---|
| GET | `/` | `Home::index` | Display student records |
| POST | `/home/tambah` | `Home::tambah` | Create a student |
| GET | `/home/hapus/(:num)` | `Home::hapus/$1` | Delete a student by ID |
| POST | `/home/edit/(:num)` | `Home::edit/$1` | Update a student by ID |

Auto-routing is disabled in `app/Config/Routing.php`; keep explicit routes registered for new actions.

## Relevant File Structure

```text
ci_siswa/
├── .env
├── app/
│   ├── Config/
│   │   └── Routes.php
│   ├── Controllers/
│   │   └── Home.php
│   ├── Database/
│   │   └── Seeds/
│   │       └── SiswaSeeder.php
│   ├── Models/
│   │   └── SiswaModel.php
│   └── Views/
│       └── siswa_view.php
├── public/
│   └── index.php
├── system/
├── tests/
└── writable/
```

## Checkpoint History

1. **Checkpoint 1 — Project foundation:** Initial application setup; detailed slide requirements were not recorded in this update.
2. **Checkpoint 2 — Database foundation:** Project uses the `db_rpl_siswa` database and `siswa` table; detailed slide requirements were not recorded here.
3. **Checkpoint 3 — Bootstrap/UI foundation:** Bootstrap 5 is included in the student view; detailed slide requirements were not recorded here.
4. **Checkpoint 4 — Read/list students:** `SiswaModel::getSiswa()` retrieves all students; `Home::index()` passes them to the view, which displays the records or an empty-state message.
5. **Checkpoint 5 — Create students:** A Bootstrap modal posts student fields to `Home::tambah()`, which saves the record and redirects to the base URL.
6. **Checkpoint 6 — Delete students:** Each row has a delete link with a confirmation prompt; `Home::hapus($id)` deletes the record.
7. **Checkpoint 7 — Edit/update students:** Each row has an edit button and a unique prefilled modal; `Home::edit($id)` updates the record.
8. **Checkpoint 8 — Navbar presentation update:** Added the Bootstrap 5 navbar above the main content. The exact checkpoint title beyond this UI request was not specified.
9. **Pagination and sample data — v1.2.0:** Student listing uses CI4 `paginate(10)` with pager links. Added an idempotent seeder with sample student records. The Edit modal submit button is green.
10. **UI formatting — v1.2.1:** Replaced the default pager output with Bootstrap Previous and Next buttons aligned left and right, changed the Edit modal header to green (`bg-success`), and reduced the seeder's demo dataset to 14 records for a two-page test (10 on page one, 4 on page two).
11. **Continuous pagination numbering — v1.2.2:** `Home::index()` passes the current page and page size to the view; row numbering starts at `(($page - 1) * $perPage) + 1` so numbering continues across pages.
12. **Tailwind CSS & Collapsible Sidebar UI upgrade - v1.3.0:** Migrated the frontend framework from Bootstrap 5 to Tailwind CSS via CDN and Alpine.js / Vanilla JS. Implemented a responsive collapsible sidebar (desktop 60px to 300px width transition on hover or toggle pin, and mobile slide-in overlay drawer with backdrop), modern top navbar, clean student data table with cross-page dynamic numbering, styled Create and Edit modals (retaining the emerald-green header for edit modals), and preserved all CodeIgniter 4 backend CRUD routes and CSRF protection without altering `Home.php` or `SiswaModel.php`.
13. **Dropdown Kelas / Jurusan selection & Backend Validation:** Replaced the plain text input for `kelas` in both Create (`#modalTambah`) and Edit (`#modalEdit<?= $row['id'] ?>`) modals with structured `<select>` dropdowns categorized by `<optgroup>` for RPL, MM, and BC. In the Edit modal, the dropdown automatically detects and selects previously saved database values. Added backend validation in `Home::tambah()` and `Home::edit()` to validate and accept class selections.

## Version Details

- **Project/assignment version:** `v1.3.0`
- This is the project version requested for the update notes; it is not a claim about the installed CodeIgniter framework release.
- `composer.json` requires PHP `^8.2`.
