# Notes App (PHP + MySQL + Docker)

Ett enkelt anteckningsapp där användare kan registrera sig, logga in, skapa, redigera, ta bort och visa anteckningar.

---

## Krav

- Docker
- Docker Compose

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

3. Öppna webbläsaren och gå till:
    ```
    http://localhost:8080/
    ```

---

## Användning

- **Registrera användare:** Via sidan Register.
- **Logga in:** Via sidan Login.
- **Skapa anteckning:** När du är inloggad, klicka på Add New Note.
- **Redigera/Ta bort anteckning:** Endast dina egna anteckningar.
- **Logga ut:** Via länken Logout.

---

## Skärmdump

![screenshot](screenshot.png)

---

## Extra info

- Lösenord sparas krypterat.
- Endast ägaren kan redigera eller ta bort sina anteckningar.
- All data sparas i MySQL via Docker.

