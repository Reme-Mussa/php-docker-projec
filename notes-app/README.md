# Notes App (PHP + MySQL + Docker)

Ett enkelt anteckningsapp där användare kan registrera sig, logga in, skapa, redigera, ta bort och visa anteckningar.

---

## Krav

- Docker
- Docker Compose
- Git

---

## Kom igång

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
    http://localhost:8080/pages/notes.php
    ```

---

## Användning

### För besökare:
- Se lista över alla anteckningar (endast läsning)

### För inloggade användare:
- Se alla anteckningar
- Skapa nya anteckningar
- Redigera egna anteckningar
- Ta bort egna anteckningar

### Säkerhet:
- Lösenord sparas krypterat med PHP password_hash()
- All användarinput valideras
- CSRF-skydd implementerat
- XSS-skydd implementerat

---

## Skärmdump

![Notes App Screenshot](screenshot.png)

---

## Teknisk information

- Backend: PHP med snake_case namngivning
- Frontend: HTML, CSS, JavaScript med camelCase namngivning
- Databas: MySQL 5.7
- Container: Docker

---

## Utvecklare

Detta projekt är utvecklat som en del av PHP-kursen.

---

## Licens

MIT License
