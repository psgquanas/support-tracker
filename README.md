<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/MySQL-database-4479A1?logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/Tailwind_CSS-UI-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
<img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

<h1 align="center">Support Activity Tracker</h1>

<p align="center">
A Laravel application for applications support teams to track daily activities, record who updated what and when, and hand over pending work between shifts.
<br>
<strong>Npontu Technologies | Platforms Developer Assignment</strong>
</p>

<p align="center">
<a href="https://github.com/psgquanas/support-tracker"><strong>Repository</strong></a>
</p>

## About the Project

Support teams run recurring daily checks, such as comparing the SMS count reported by the system against the SMS count from the logs. When a shift ends, the next person needs to know what was done, what is still pending, who touched it last, and why.

Support Activity Tracker solves this by giving the team one place to:

- Log daily activities, including system count versus log count comparisons.
- Mark each activity as **done** or **pending** with a remark.
- Automatically record the person and the exact time of every update.
- View a day-by-day handover timeline of all activities and updates.
- Query activity history across custom date ranges and export it to CSV.
- Restrict access to authenticated staff only.

## Requirements Covered

| # | Requirement | How it is met |
|---|-------------|---------------|
| 1 | Input activities such as "Daily SMS count vs SMS count from logs" | **New Activity** form with title, date, description, system count and log count. A mismatch indicator shows the difference. |
| 2 | Update status to done or pending, with a remark | Inline update form (status and remark) on every activity. |
| 3 | Capture bio details of the updater and the time | Each update stores the logged-in user and a timestamp. Staff ID and phone are collected at registration and shown beside each update. |
| 4 | Daily view of all activities and their updates | **Handover** page: pick any date and see every activity with a timeline of who updated it, to what, and at what time. Pending items from earlier days appear in a carry-over banner. |
| 5 | Reporting view for custom durations | **Reports** page with from/to dates, status filter, summary statistics, full history and CSV export. |
| 6 | User authentication | Laravel Breeze (register, login, logout). All application routes are behind the `auth` middleware. |

## Features

- Daily handover view with a per-activity update timeline
- Carry-over banner for activities still pending from previous days
- System count versus log count reconciliation with mismatch highlighting
- Date-range reports with status filtering and summary cards
- CSV export of the filtered report
- Colour-coded status badges and a responsive layout
- Staff ID and phone captured at registration and shown on every update

## Tech Stack

- [Laravel](https://laravel.com) (PHP 8.2+)
- MySQL
- Blade templates with [Tailwind CSS](https://tailwindcss.com) via Vite
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) for authentication
- Deployed on [Railway](https://railway.com)

## Data Model

| Table | Columns |
|-------|---------|
| `users` | name, email, password, `staff_id`, `phone`, `role` |
| `activities` | title, description, `activity_date` (indexed), `system_count`, `log_count`, `status`, `created_by` |
| `activity_updates` | `activity_id`, `user_id`, `status`, `remark`, `created_at` (indexed) |

Each status change **adds a row** to `activity_updates` and refreshes the current status on the activity. History is never overwritten.

## Design Decisions and Non-Functional Requirements

**Auditability**
- Updates are append-only, so the full history of any activity can always be reconstructed.
- The new history row and the status refresh are written in a single database transaction so they cannot get out of sync.

**Security**
- Passwords are hashed by Laravel.
- CSRF protection on every form.
- Server-side validation on all inputs (types, lengths, allowed status values, date ranges).
- Eloquent query bindings prevent SQL injection, and Blade escapes output to prevent XSS.
- Secrets live in environment variables, never in the repository.
- `APP_DEBUG=false` in production.

**Performance and Scalability**
- `activity_date` and `created_at` are indexed because every view and report filters on them.
- Eager loading (`with()`) avoids N+1 queries on the handover and report pages.
- Report results are paginated.

**Usability**
- The handover page is built around the real use case: the next person on shift sees what is pending, who touched it last, and the remark left.
- Pending items from earlier days are surfaced automatically so nothing is forgotten.
- Responsive layout that works on mobile.

**Maintainability**
- Standard Laravel structure: migrations, models, controllers, Blade views.
- Reusable Blade partial for the activity card and shared layout components.
- Relationships defined on models (`Activity::updates()`, `ActivityUpdate::user()`).

**Reliability**
- Timezone set to `Africa/Accra` so recorded times match the team's local time.
- Production logs go to stderr so errors are visible in the host's logs.

## Getting Started

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL

### Installation

```bash
git clone https://github.com/YOUR-USERNAME/support-tracker.git
cd support-tracker

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create a MySQL database, then configure `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=support_tracker
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations and start the app:

```bash
php artisan migrate

npm run dev          # terminal 1
php artisan serve    # terminal 2
```

Open `http://127.0.0.1:8000` and register an account.

## Routes

| Method | URL | Purpose |
|--------|-----|---------|
| GET | `/activities` | Daily handover view (`?date=YYYY-MM-DD`) |
| GET | `/activities/create` | New activity form |
| POST | `/activities` | Save a new activity |
| POST | `/activities/{activity}/updates` | Add a status update with remark |
| GET | `/reports` | Report by date range and status |
| GET | `/reports/export` | CSV export of the filtered report |

## Deployment

The app is deployed on Railway:

1. Push the repository to GitHub.
2. Create a Railway project from the repo and add a MySQL database.
3. Set `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` and the `DB_*` variables linked to the MySQL service.
4. Set the pre-deploy command to `php artisan migrate --force`.
5. Generate a public domain.

## Future Improvements

- Role-based access (admin versus support staff) using the existing `role` column.
- Recurring activity templates so daily checks are created automatically.
- Email or in-app notification when a pending item is handed over.
- Automated tests for the update and report logic.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
