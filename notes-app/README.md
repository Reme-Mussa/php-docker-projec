# Notes App (PHP + MySQL + Docker)

Ett enkelt anteckningsapp där användare kan registrera sig, logga in, skapa, redigera, ta bort och visa anteckningar.

## Innehållsförteckning
- [Krav](#krav)
- [Installation](#installation)
- [Användning](#användning)
- [Säkerhet](#säkerhet)
- [Teknisk information](#teknisk-information)
- [Projektstruktur](#projektstruktur)
- [Utveckling](#utveckling)

## Krav

För att köra detta projekt behöver du:
- Docker
- Docker Compose
- Git
- Webbläsare (Chrome, Firefox, Safari, etc.)

## Installation

1. Klona projektet:
    ```bash
    git clone https://github.com/dittanvändarnamn/notes-app.git
    cd notes-app
    ```

2. Starta containrarna:
    ```bash
    docker compose up -d
    ```

3. Vänta några sekunder tills containrarna är igång

4. Öppna webbläsaren och gå till:
    ```
    http://localhost:8080
    ```

5. För att hantera databasen, gå till phpMyAdmin:
    ```
    http://localhost:8081
    ```
    Användarnamn: root
    Lösenord: notes_root_password

## Användning

### För besökare:
- Se lista över alla anteckningar (endast läsning)
- Registrera nytt konto
- Logga in med befintligt konto

### För inloggade användare:
- Se alla anteckningar
- Skapa nya anteckningar
- Redigera egna anteckningar
- Ta bort egna anteckningar
- Logga ut

## Säkerhet

Applikationen implementerar flera säkerhetsåtgärder:

### Användarsäkerhet
- Lösenord sparas krypterat med PHP password_hash()
- Sessioner hanteras säkert med regenerering av ID
- Säker cookie-hantering med HttpOnly och Secure flaggor

### Datasäkerhet
- All användarinput valideras
- CSRF-skydd implementerat
- XSS-skydd med htmlspecialchars()
- SQL-injection skydd med PDO prepared statements

### Databassäkerhet
- Säker databasanslutning med PDO
- Användarinput valideras mot datatyp
- Felhantering utan exponering av känslig information

## Teknisk information

### Backend
- PHP 8.x
- PDO för databasanslutning
- Session-baserad autentisering
- RESTful API-design

### Frontend
- HTML5
- CSS3
- Responsiv design
- Formulärvalidering

### Databas
- MySQL 5.7
- UTF-8MB4 teckenkodning
- InnoDB storage engine
- Foreign key constraints

### Container
- Docker
- Docker Compose
- phpMyAdmin för databashantering

## Projektstruktur

```
notes-app/
├── src/
│   ├── includes/
│   │   └── db_connect.php
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── notes.php
│   ├── add_note.php
│   ├── edit_note.php
│   ├── delete_note.php
│   ├── logout.php
│   └── styles.css
├── init.sql
├── docker-compose.yml
├── Dockerfile
└── README.md
```

### Varför init.sql?

Vi använder `init.sql` för att automatiskt skapa databasstrukturen när containern startar. Detta ger flera fördelar:
1. Automatisk databasinitialisering vid första start
2. Konsekvent databasstruktur mellan olika miljöer
3. Enkel versionering av databasändringar
4. Möjlighet att återskapa databasen från scratch vid behov

## Utveckling

Detta projekt är utvecklat från grunden som en del av PHP-kursen. Här är de viktigaste delarna av utvecklingen:

### 1. Grundstruktur
- Skapade grundläggande filstruktur
- Implementerade Docker-konfiguration
- Skapade databasstruktur med init.sql

### 2. Användarhantering
- Implementerade registrering och inloggning
- Lade till lösenordskryptering
- Skapade sessionshantering

### 3. Anteckningshantering
- Implementerade CRUD-funktionalitet
- Lade till användarbehörigheter
- Implementerade säkerhetsåtgärder

### 4. Förbättringar
- Optimerade databasstruktur
- Förbättrade användargränssnitt
- Lade till felhantering

## Licens

MIT License
