# 📺 Rateflix App

Ein modernes Laravel 12-Projekt zum Bewerten und Verwalten von Filmen und Serien. Dieses Projekt verwendet das offizielle **Livewire Starter Kit** mit **Laravel Volt** und eingebautem **Authentifizierungssystem**.

---

## 🚀 Features

-   ✅ Laravel 12 mit PHP 8.3+
-   ⚡ Livewire 3 (Reactive UI ohne JavaScript)
-   🎨 Laravel Volt (komponentenbasiertes UI mit Tailwind CSS)
-   🔐 Built-in Auth (Login, Registrierung, Passwort-Reset)
-   🧪 Pest für modernes Testing
-   🧩 Modular aufgebaut für zukünftige Features (Bewertungen, Watchlists, uvm.)

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

### 4. Datenbank vorbereiten

```bash
touch database/database.sqlite
php artisan migrate
```

### 5. Lokalen Server starten

```bash
php artisan serve
```

➡ Jetzt kannst du die App unter http://127.0.0.1:8000 im Browser aufrufen.

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
php artisan test
# oder
vendor/bin/pest
```
