Support Activity Tracker

A Laravel web application that helps an applications support team track their daily activities, record who updated what and when, and hand over pending work cleanly between shifts.

Built as the Npontu Technologies Platforms Developer assignment.

Live URL: https://YOUR-APP.up.railway.app
Demo login: demo@example.com / YourDemoPassword
Repository: https://github.com/YOUR-USERNAME/support-tracker
Requirements and how they are met
#	Requirement	Implementation
1	Input activities such as "Daily SMS count vs SMS count from logs"	New Activity form with title, date, description, system count and log count. A mismatch warning shows the difference between the two counts.
2	Update status to done or pending, with a remark	Each activity has an inline update form (status + remark) on the handover page.
3	Capture bio details of the person updating, and the time	Every update stores the logged-in user and a timestamp. Staff ID and phone are collected at registration and shown beside each update.
4	Daily view of all activities and their updates	Handover page: pick any date and see every activity with a timeline of updates (status, person, time, remark). Activities still pending from earlier days appear in a highlighted carry-over banner.
5	Reporting view for custom durations	Reports page: choose a from/to date and optional status filter, see summary stats (total, done, pending, mismatches) and the full update history. Results can be exported to CSV.
6	User authentication	Laravel Breeze: registration, login, logout. All application pages sit behind the auth middleware.
Tech stack
Laravel (PHP 8.2+)
MySQL
Blade templates with Tailwind CSS (via Vite)
Laravel Breeze for authentication
Deployed on Railway
Data model
users: name, email, password, staff_id, phone, role
activities: title, description, activity_date (indexed), system_count, log_count, current status, created_by
activity_updates: activity_id, user_id, status, remark, created_at

Each status change adds a row to activity_updates and refreshes the current status on the activity. History is never overwritten.

Design decisions and non-functional requirements

Auditability Updates are append-only. Every change records who made it and when, so the full history of any activity can always be reconstructed. The status change and the history row are written in a single database transaction so they cannot get out of sync.

Security

Passwords are hashed (bcrypt) by Laravel
CSRF protection on every form
Server-side validation on all inputs (types, lengths, allowed status values, date ranges)
Eloquent query bindings prevent SQL injection
Blade escapes output by default, which protects against XSS
Secrets live in environment variables, never in the repository
APP_DEBUG=false in production

Performance and scalability

activity_date and created_at are indexed because every view and report filters on them
Eager loading (with()) avoids N+1 queries on the handover and report pages
Report results are paginated

Usability

The handover page is built around the real use case: the next person on shift can immediately see what is pending, who touched it last, and the remark they left
Pending items from earlier days are surfaced automatically so nothing is forgotten
Colour-coded status badges and a timeline layout
Responsive layout that works on mobile

Maintainability

Standard Laravel structure (migrations, models, controllers, Blade views)
Reusable Blade partial for the activity card, shared components for the layout
Relationships are defined on the models (Activity::updates(), ActivityUpdate::user())

Reliability

Timezone set to Africa/Accra so recorded times match the team's local time
Logging goes to stderr in production so errors are visible in the host's logs
Running locally

Requirements: PHP 8.2+, Composer, Node.js, MySQL.

bash
git clone https://github.com/YOUR-USERNAME/support-tracker.git
cd support-tracker

composer install
npm install

cp .env.example .env
php artisan key:generate

Create a MySQL database, then set these in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=support_tracker
DB_USERNAME=root
DB_PASSWORD=

Then:

bash
php artisan migrate
npm run dev          # in one terminal
php artisan serve    # in another

Open http://127.0.0.1:8000 and register an account.

Deployment (Railway)
Push the repository to GitHub
Create a Railway project from the repo and add a MySQL database
Set environment variables (APP_KEY, APP_ENV=production, APP_DEBUG=false, APP_URL, and the DB_* values linked to the MySQL service)
Set the pre-deploy command to php artisan migrate --force
Generate a public domain
Routes
Method	URL	Purpose
GET	/activities	Daily handover view (?date=YYYY-MM-DD)
GET	/activities/create	New activity form
POST	/activities	Save a new activity
POST	/activities/{activity}/updates	Add a status update with remark
GET	/reports	Report by date range and status
GET	/reports/export	CSV export of the filtered report
Possible improvements
Role-based access (admin vs support staff) using the existing role column
Recurring activity templates so daily checks are created automatically
Email or in-app notification when a pending item is handed over
Automated tests for the update and report logic
