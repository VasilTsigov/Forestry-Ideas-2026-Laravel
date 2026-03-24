# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Forestry Ideas** is a Laravel 13 web application for an international forestry journal published by the University of Forestry, Sofia, Bulgaria. It migrates content from a legacy database and serves journal articles, issues, conferences, and static pages.

## Commands

```bash
# Initial setup (install, migrate, build assets)
composer setup

# Start full dev environment (PHP server + queue + logs + Vite HMR, all concurrent)
composer dev

# Run tests
composer test

# Run a single test file
php artisan test --filter=TestClassName

# Lint/format PHP with Laravel Pint
./vendor/bin/pint

# HTML normalization (preview changes without saving)
php artisan articles:normalize-html --dry-run
php artisan articles:normalize-html --dry-run --field=issueSummary

# Apply HTML normalization to the database
php artisan articles:normalize-html
```

## Architecture

### Domain-Driven Structure

Controllers and models are organized under `app/Domains/` by feature domain, not by type:

```
app/Domains/
  Article/Controllers/ArticleController.php
  Article/Models/Article.php          ← maps to `issue` table
  Magazine/Controllers/MagazineController.php
  Magazine/Models/Magazine.php        ← maps to `journal` table
  Conference/Controllers/ConferenceController.php
  Conference/Models/Conference.php    ← maps to `conferences` table
  Contact/Controllers/ContactController.php
  Contact/Models/Contact.php
  News/Controllers/NewsController.php
  News/Models/News.php
  Page/Controllers/PageController.php
  Page/Models/Home.php                ← single-row DB table
  Page/Models/InstructionToAuthors.php
  Page/Models/PublicationEthics.php
  Page/Models/Subscription.php
  Admin/Controllers/NormalizeHtmlController.php
```

### Legacy Database Schema

The database uses a legacy naming convention — all models explicitly declare `$table`, `$primaryKey`, and `$timestamps = false`. Key mappings:

| Domain class | DB table | Primary key |
|---|---|---|
| `Magazine` | `journal` | `journalID` |
| `Article` | `issue` | `issueID` |
| `Conference` | `conferences` | `confID` |

Article fields: `issueTitle`, `issueSummary`, `issueAutor`, `issueFrom`, `issueFile`, `issueJournalID`, `issueCount`
Magazine fields: `journalVolume`, `journalNr`, `journalYear`, `journalTitle`, `journalFile`, `journalFileContent`, `journalCount`

**Relationships:** `Magazine` hasMany `Article` via `issueJournalID → journalID`.

### File Storage

PDFs are served from `storage/app/files/` (not `public/`), split into subdirectories:
- `storage/app/files/issue/` — individual article PDFs
- `storage/app/files/journal/` — full journal issue PDFs
- `storage/app/files/journal_content/` — journal table-of-contents PDFs

The `DownloadController` increments `issueCount`/`journalCount` on each download and streams files via `response()->download()`.

### Static Pages

Publication ethics, subscription, and instructions-to-authors content is stored as HTML in single-row database tables. `PageController` fetches via `::firstOrFail()` and views render with `{!! $page->field !!}`. Apply `.db-content` CSS class to wrappers for consistent font rendering.

### Blade Layout

All pages extend `layouts/app.blade.php` which provides:
- Sticky nav header with active-state highlighting via `request()->routeIs()`
- Default forest/navy gradient hero (overridable with `@section('hero')`)
- Two-column main layout: content (left) + sticky sidebar (right, 18rem)
- `@yield('page-title')` and `@yield('page-subtitle')` for the hero

### Frontend

Tailwind CSS v4 (via `@import 'tailwindcss'` syntax — not the v3 plugin approach). Custom color tokens defined in `resources/css/app.css`:
- `navy-900/800/700/100/50` — dark green brand colors
- `forest-700/600/500/400/100/50` — mid green accent colors

Fonts: Inter (sans, body) and Merriweather (serif, headings). The `.section-title` utility class applies standard section heading styles.

### Admin Routes

`/admin/normalize-html` and `/admin/diagnostics` are currently unprotected (no auth middleware). Auth is planned but not yet implemented for admin.

### HTML Normalization

Article HTML fields from the legacy database contain browser extension artifacts (Ginger spell-checker injections) and inconsistent markup. Two normalization paths exist:
- `NormalizeHtmlController` — web UI at `/admin/normalize-html` with preview + apply
- `articles:normalize-html` artisan command — same logic, CLI-friendly with `--dry-run`

Allowed HTML tags after normalization: `<p>`, `<br>`, `<strong>`, `<em>` — all attributes stripped.
