# 📺 Rateflix App

Ein modernes Laravel 12-Projekt zum Bewerten und Verwalten von Filmen und Serien. Dieses Projekt verwendet das offizielle **Livewire Starter Kit** mit **Laravel Volt** und eingebautem **Authentifizierungssystem**.

---

## 🚀 Features

-   ✅ Laravel 12 mit PHP 8.4+
-   ⚡ Livewire 3 (Reactive UI ohne JavaScript)
-   🎨 Flux UI Components (Moderne UI Library)
-   🔐 Built-in Auth (Login, Registrierung, Passwort-Reset)
-   🎬 OMDB API Integration für Filmsuche
-   ⭐ Bewertungssystem (1-5 Sterne)
-   🧪 Pest für modernes Testing (38+ Tests)
-   🐳 Docker-Ready für einfaches Deployment
-   🚀 CI/CD mit GitHub Actions

---

## 🛠️ Setup-Anleitung

### 1. Projekt klonen

```bash
git clone https://github.com/dein-nutzername/rateflix-app.git
cd rateflix-app
```

### 2. Abhängigkeiten installieren

```bash
composer install
npm install && npm run dev
```

### 3. Umgebungsdatei erstellen

```bash
cp .env.example .env
php artisan key:generate
```

### 4. OMDB API-Schlüssel konfigurieren

Für die Filmsuche wird die OMDB API verwendet.

**🔑 Der OMDB API-Schlüssel wird aus Sicherheitsgründen separat per E-Mail bereitgestellt.**

Füge den erhaltenen API-Schlüssel in deine `.env` Datei ein:

```env
OMDB_API_KEY=dein_erhaltener_api_schlüssel
```

> **Hinweis**: Du kannst auch deinen eigenen kostenlosen API-Schlüssel auf [omdbapi.com](http://www.omdbapi.com/apikey.aspx) registrieren.

### 5. Datenbank vorbereiten

```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
```

### 6. Lokalen Server starten

```bash
# Laravel Server starten
php artisan serve

# In einem zweiten Terminal: Vite Dev Server für CSS/JS
npm run dev
```

➡ Jetzt kannst du die App unter http://127.0.0.1:8000 im Browser aufrufen.

---

## 🎬 Features der App

-   **Filmsuche**: Suche nach Filmen über die OMDB API
-   **Bewertungssystem**: Bewerte Filme von 1-5 Sternen
-   **Dashboard**: Übersicht deiner Bewertungen
-   **Responsive Design**: Optimiert für Desktop und Mobile
-   **Moderne UI**: Clean Design mit Flux UI Components

## 🔐 Authentifizierung

-   Login: /login
-   Registrierung: /register
-   Passwort vergessen: /forgot-password
-   Nach Login: /dashboard

## 📦 Tools & Pakete

-   Livewire -> Reactive Components ohne JS
-   Laravel Volt -> View-basierte Komponenten
-   Tailwind CSS -> Utility-First CSS
-   Pest Eleganter -> Testing-Framework
-   Laravel Sail (Optional) -> Docker Support

## ✅ Tests ausführen

```bash
# Alle Tests ausführen
php artisan test

# Mit Pest (alternative Syntax)
vendor/bin/pest

# Tests mit Coverage Report
vendor/bin/pest --coverage

# Einzelne Test-Suite ausführen
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

---

## 🚀 Deployment

Die App ist bereits für die Produktion konfiguriert und läuft auf Railway. Siehe die `start.sh` und `Dockerfile` für Details zur Containerisierung.

**Live Demo**: [App auf Railway ansehen](https://rateflix-app-production.up.railway.app)

### Technische Details

-   **Framework**: Laravel 12 mit PHP 8.4
-   **Frontend**: TALL Stack (Tailwind, Alpine, Livewire, Laravel)
-   **Database**: SQLite (Development) / PostgreSQL (Production bereit)
-   **Testing**: Pest Framework mit 38+ Tests
-   **CI/CD**: GitHub Actions mit automatischen Tests
-   **Deployment**: Docker Container auf Railway Platform

---

## 🤝 Entwicklung

### Projekt-Struktur

```
app/
├── Http/Controllers/     # Standard Laravel Controllers
├── Livewire/            # Livewire Components
│   └── Actions/         # Action Classes
├── Models/              # Eloquent Models (User, UserRating)
└── Services/            # Business Logic (OmdbService, UserRatingService)

resources/
├── views/               # Blade Templates
│   ├── livewire/        # Livewire Component Views
│   └── components/      # Reusable UI Components
└── css/                 # Tailwind CSS

tests/
├── Feature/             # Feature Tests (38 Tests)
└── Unit/                # Unit Tests
```

### Coding Standards

Das Projekt folgt Laravel Best Practices:

-   PSR-12 Coding Standards
-   Service Layer Pattern
-   Repository Pattern für komplexe Datenabfragen
-   Comprehensive Testing (Feature + Unit Tests)
-   Clean Code Prinzipien
