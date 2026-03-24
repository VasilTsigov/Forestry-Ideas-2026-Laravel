# Forestry Ideas — Миграция към Laravel 13
## Технически отчет

**Проект:** Научно списание „Forestry Ideas"
**Дата:** 24 март 2026 г.
**Среда:** Laravel 13, PHP 8.3, MySQL 8.0, Tailwind CSS v4, Vite 5

---

## 1. Цел на проекта

Пълна миграция на уеб сайта на научното списание „Forestry Ideas" от остарял PHP 5.6 (без рамка, с `mysql_*` функции и Dreamweaver шаблони) към съвременен стек — Laravel 13 с MVC архитектура, Tailwind CSS и защитено сервиране на PDF файлове.

---

## 2. Технически стек

| Компонент | Версия |
|---|---|
| PHP | 8.3 |
| Laravel | 13 |
| База данни | MySQL 8.0.31 |
| CSS Framework | Tailwind CSS v4 |
| Build tool | Vite 5 |
| Локална среда | Herd + WampServer |
| URL | http://forestry-ideas.test |

---

## 3. Структура на проекта

Проектът използва domain-based архитектура под `app/Domains/`:

```
app/
  Domains/
    Magazine/
      Controllers/MagazineController.php
      Models/Magazine.php
    Article/
      Controllers/ArticleController.php
      Models/Article.php
    Conference/
      Controllers/ConferenceController.php
      Models/Conference.php
    News/
      Controllers/NewsController.php
      Models/News.php
    Page/
      Controllers/PageController.php
      Models/PublicationEthics.php
      Models/Subscription.php
      Models/InstructionToAuthors.php
    Contact/
      Controllers/ContactController.php
      Models/Contact.php
    Admin/
      Controllers/NormalizeHtmlController.php
    Download/
      Controllers/DownloadController.php
  Http/Controllers/
    HomeController.php
    Auth/LoginController.php
  Console/Commands/
    NormalizeArticleHtml.php
  Providers/
    AppServiceProvider.php
```

---

## 4. Маршрути (routes/web.php)

| Метод | URL | Контролер | Описание |
|---|---|---|---|
| GET | `/` | HomeController@index | Начална страница |
| GET | `/journal` | MagazineController@index | Съдържание — списък на броевете |
| GET | `/journal/{id}` | MagazineController@show | Детайли за брой |
| GET | `/issues` | MagazineController@issues | Статии по брой (с dropdown и пагинация) |
| GET | `/articles/{id}` | ArticleController@show | Детайли на статия |
| GET | `/news` | NewsController@index | Новини |
| GET | `/conferences` | ConferenceController@index | Конференции |
| GET | `/publication-ethics` | PageController | Публикационна етика |
| GET | `/subscription` | PageController | Абонамент |
| GET | `/instructions-to-authors` | PageController | Указания за автори |
| GET+POST | `/contact` | ContactController | Контактна форма |
| GET+POST | `/login` | Auth\LoginController | Вход |
| POST | `/logout` | Auth\LoginController | Изход |
| GET | `/download/article/{id}` | DownloadController@article | PDF на статия |
| GET | `/download/journal/{id}` | DownloadController@journal | PDF на пълен брой |
| GET | `/download/conference/{id}` | DownloadController@conference | PDF на конференция |
| GET | `/admin/normalize-html` | NormalizeHtmlController@index | Преглед на HTML нормализация |
| POST | `/admin/normalize-html` | NormalizeHtmlController@apply | Прилагане на HTML нормализация |
| GET | `/admin/diagnostics` | (inline) | Диагностика за Ginger текст |

---

## 5. База данни

### Таблици

| Таблица | Записи | Описание |
|---|---|---|
| `journal` | ~30+ | Броеве на списанието (journalID, journalTitle, journalYear, journalVolume, journalNr, journalFile, journalFileContent, journalCount) |
| `issue` | 221 | Научни статии (issueID, issueJournalID, issueTitle, issueAutor, issueFrom, issueSummary, issueFile, issueCount) |
| `conferences` | ~10+ | Конференции (confID, confTitle, confDate, confFileName) |
| `contacts` | 0 | Контактни запитвания (Laravel timestamps) |
| `instr_to_autors` | 1 | Указания за автори |
| `pub_ethics` | 1 | Публикационна етика |
| `subscription` | 1 | Абонаментна информация |
| `users` | 1 | Laravel стандартна таблица |

### Миграции

- `2025_03_23_000001_create_magazine_table` — Добавяне на `journal` таблицата
- `2025_03_23_000002_add_missing_columns_to_conferences_table` — Добавяне на `confFileName`, `confDate`
- `2025_03_23_000003_create_home_table` — Начална страница
- `2025_03_24_000001_expand_issue_text_columns` — Разширяване на `issueTitle`, `issueSummary`, `issueAutor`, `issueFrom` от VARCHAR към TEXT/MEDIUMTEXT

---

## 6. Изпълнени задачи

### 6.1 Основна миграция

Пренесени са всички публични страници с пълна функционалност:

- Начална страница с динамично съдържание от базата данни
- Съдържание (`/journal`) — списък на всички броеве с брой статии
- Issues (`/issues`) — филтриране по брой чрез dropdown, пагинация 10 статии/страница
- Статии (`/articles/{id}`) — пълен изглед на статия
- Новини, Конференции, Статични страници
- Контактна форма

### 6.2 Tailwind CSS v4 и оформление

Преработен изцяло layout с Tailwind CSS v4:

- Зелена навигационна лента, горен хедър с лого
- Hero bar с заглавие и подзаглавие (`@section('page-title')` / `@section('page-subtitle')`)
- Двуколонен CSS Grid layout — основно съдържание (ляво) + Редакционен съвет (дясно)
- Tailwind пагинатор конфигуриран глобално в `AppServiceProvider`:

```php
Paginator::defaultView('pagination::tailwind');
Paginator::defaultSimpleView('pagination::simple-tailwind');
```

### 6.3 Решаване на layout проблем — Sidebar

**Проблем:** Редакционният съвет (sidebar) се появяваше в дъното на страницата вместо вдясно, при зареждане на страницата Issues.

**Причина:** HTML съдържание от базата данни съдържаше излишни `</div>` тагове, които затваряха grid контейнера преди `<aside>` да е рендериран.

**Решение:** `<aside>` се рендерира ПРЕДИ основното съдържание в DOM, с явно `grid-column` позициониране:

```html
<div style="display:grid; grid-template-columns:minmax(0,1fr) 18rem; gap:2.5rem">
    <aside style="grid-column:2; grid-row:1;">
        <!-- Редакционен съвет -->
    </aside>
    <div style="grid-column:1; grid-row:1; min-width:0;">
        @yield('content')
    </div>
</div>
```

### 6.4 Нормализация на HTML в базата данни

**Проблем:** Статиите съдържаха разнородни HTML формати — различни тагове, стилове и атрибути, а в 28 записа имаше паразитен текст от браузърната разширка „Ginger" (Enable Ginger, Rephrase×, Disable in this text field и др.).

**Решение:**

#### Artisan команда (CLI)

```
php artisan articles:normalize-html --dry-run
php artisan articles:normalize-html
```

Поддържа `--dry-run` режим за преглед без записване и `--field` за конкретно поле.

#### Уеб интерфейс — `/admin/normalize-html`

`NormalizeHtmlController` предоставя:

- **GET** — преглед на всички статии преди/след нормализация
- **POST** — прилагане на промените в базата данни

#### Алгоритъм на почистване

1. Декодиране на HTML entities
2. Премахване на Ginger текстове (Enable Ginger, Rephrase×, ×, и др.)
3. Конвертиране на block тагове в нови редове
4. `strip_tags` — запазват се само `<p>`, `<br>`, `<strong>`, `<em>`
5. Премахване на всички атрибути (class, style, id и др.)
6. Обвиване в `<p>` параграфи

**Резултат:** 221 статии нормализирани успешно.

### 6.5 CSS клас `.db-content`

**Проблем:** Текстовото съдържание от базата данни се рендерираше с Merriweather serif шрифт вместо Inter sans-serif, тъй като браузърът интерпретираше h1-h6 тагове в HTML съдържанието.

**Решение:** Добавен CSS клас `.db-content` в `resources/css/app.css`:

```css
.db-content h1, .db-content h2, .db-content h3, .db-content h4,
.db-content h5, .db-content h6, .db-content * {
    font-family: var(--font-sans);
}
```

Класът е приложен на всички елементи, рендериращи HTML от базата данни.

### 6.6 Защита на PDF файлове

**Проблем:** PDF файловете се намираха в `public/files/` и бяха директно достъпни чрез URL без контрол.

**Решение:** Файловете са преместени в `storage/app/files/` (извън публичната директория) и се сервират чрез `DownloadController`:

- `storage/app/files/issue/` — статии
- `storage/app/files/journal/` — пълни броеве

Контролерът проверява дали файлът съществува, инкрементира брояча за сваляния и сервира файла като `BinaryFileResponse`.

### 6.7 Скриване на броеве без статии

Броевете без статии (предимно преди 2009 г.) са скрити от всички изгледи чрез `->has('articles')` в `MagazineController`:

```php
Magazine::withCount('articles')
    ->has('articles')
    ->orderByDesc('journalYear')
    ->orderByDesc('journalID')
    ->get();
```

Приложено в: Contents (`/journal`) и dropdown на Issues (`/issues`).

### 6.8 Разширяване на колони в базата данни

**Проблем:** При запис на нормализирано HTML съдържание се появяваше грешка `SQLSTATE[22001]: String data, right truncated` — VARCHAR колоните бяха прекалено малки след добавяне на `<p>` тагове.

**Решение:** Миграция `2025_03_24_000001_expand_issue_text_columns` смени:

- `issueTitle` → `TEXT`
- `issueSummary` → `MEDIUMTEXT`
- `issueAutor` → `TEXT`
- `issueFrom` → `TEXT`

---

## 7. Структура на views

```
resources/views/
  layouts/
    app.blade.php          — основен layout (grid, nav, hero bar)
  partials/
    sidebar.blade.php      — редакционен съвет
  home.blade.php
  magazine/
    index.blade.php        — съдържание (списък броеве)
    issues.blade.php       — статии по брой + пагинация
    show.blade.php         — детайли на брой
  article/
    show.blade.php         — детайли на статия
  conference/
    index.blade.php
  news/
    index.blade.php
  page/
    publication-ethics.blade.php
    subscription.blade.php
    instructions-to-authors.blade.php
  contact/
    create.blade.php
  auth/
    login.blade.php
  admin/
    normalize-html.blade.php
```

---

## 8. Предстоящи задачи

- **Административен панел** — управление на броеве, статии, новини
- **Автентикация за `/admin/*`** — добавяне на middleware
- **Новини** — попълване на данни
- **Начална страница** — динамично съдържание
- **Контактна форма** — имейл изпращане

---

## 9. Локална среда и команди

```bash
# Стартиране на dev сървър
npm run dev

# Build за production
npm run build

# Artisan команди
php artisan articles:normalize-html --dry-run
php artisan articles:normalize-html
php artisan migrate

# Диагностика
http://forestry-ideas.test/admin/diagnostics
http://forestry-ideas.test/admin/normalize-html
```

---

*Документът е генериран автоматично на 24 март 2026 г.*
