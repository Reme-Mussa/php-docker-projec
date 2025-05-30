# Notes App (PHP + MySQL + Docker)

Ett enkelt anteckningsapp där användare kan registrera sig, logga in, skapa, redigera, ta bort och visa anteckningar.

## Innehållsförteckning
- [Krav](#krav)
- [Installation](#installation)
- [Användning](#användning)
- [Säkerhet](#säkerhet)
- [Teknisk information](#teknisk-information)
- [Projektstruktur](#projektstruktur)

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
    Användarnamn: notes_user
    Lösenord: notes_password

## Användning

### För besökare:
- Bläddra bland alla anteckningar (endast läsning)
- Skapa ett nytt konto
- Logga in med ditt konto

### För inloggade användare:
- Hantera dina anteckningar enkelt
- Skapa nya anteckningar med titel och innehåll
- Redigera dina befintliga anteckningar
- Ta bort anteckningar du inte längre behöver
- Ändra ditt lösenord
- Logga ut när du är klar

### Funktioner

#### Skapa anteckningar
Skriv och spara dina tankar - snabbt och tryggt.

#### Säker åtkomst
Bara du har tillgång till dina anteckningar - full kontroll, alltid.

#### Enkel användning
Enkelt och smidigt att komma igång - inga krångligheter.

## Säkerhet

Applikationen implementerar flera säkerhetsåtgärder:

### Användarsäkerhet
- Lösenord sparas krypterat med PHP password_hash()
- Sessioner hanteras säkert
- Säker cookie-hantering

### Datasäkerhet
- All användarinput valideras
- XSS-skydd med htmlspecialchars()
- SQL-injection skydd med PDO prepared statements

### Databassäkerhet
- Säker databasanslutning med PDO
- Användarinput valideras mot datatyp
- Felhantering utan exponering av känslig information

## Teknisk information

### Backend
- PHP 8.1
- PDO för databasanslutning
- Session-baserad autentisering

### Frontend
- HTML5
- CSS3
- Responsiv design

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
│   ├── add_note.php
│   ├── change_password.php
│   ├── delete_note.php
│   ├── edit_note.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── notes.php
│   ├── register.php
│   └── styles.css
├── composer.json
├── docker-compose.yml
├── Dockerfile
├── init.sql
└── README.md
```

### Databasstruktur

Databasen består av två huvudtabeller:

1. **users**
   - id (INT, PRIMARY KEY, AUTO_INCREMENT)
   - username (VARCHAR(255), UNIQUE)
   - password (VARCHAR(255))
   - created_at (TIMESTAMP)

2. **notes**
   - id (INT, PRIMARY KEY, AUTO_INCREMENT)
   - user_id (INT, FOREIGN KEY)
   - title (VARCHAR(255))
   - content (TEXT)
   - created_at (TIMESTAMP)

Relationer:
- En användare kan ha flera anteckningar (1:N)
- Varje anteckning tillhör en användare
- ON DELETE CASCADE säkerställer att anteckningar tas bort när användaren tas bort

## Projektinformation
Utvecklad av: Reme
Version: 1.0
Senast uppdaterad: 2025

## Licens

MIT License