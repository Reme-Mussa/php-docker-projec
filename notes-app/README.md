# Anteckningsapplikation

En enkel webbapplikation där användare kan skapa och hantera sina anteckningar.

## Installation

### Krav
- Docker
- Docker Compose

### Steg för att starta applikationen

1. Klona detta repository:
```bash
git clone [repository-url]
cd notes-app
```

2. Starta Docker-containrarna:
```bash
docker-compose up -d
```

3. Öppna webbläsaren och gå till:
- Applikationen: http://localhost:8000
- phpMyAdmin: http://localhost:8080
  - Användarnamn: notes_user
  - Lösenord: notes_password

## Användning

### Registrering
1. Klicka på "Registrera dig" på inloggningssidan
2. Fyll i användarnamn och lösenord
3. Klicka på "Registrera"

### Inloggning
1. Ange ditt användarnamn och lösenord
2. Klicka på "Logga in"

### Hantera anteckningar
- Skapa ny anteckning: Klicka på "Lägg till ny anteckning"
- Redigera anteckning: Klicka på "Redigera" på den anteckning du vill ändra
- Ta bort anteckning: Klicka på "Ta bort" på den anteckning du vill ta bort

## Projektstruktur

```
notes-app/
├── src/                    # Källkod
│   ├── includes/          # Hjälpfunktioner och databasanslutning
│   ├── index.php          # Huvudsida
│   ├── login.php          # Inloggningssida
│   ├── register.php       # Registreringssida
│   └── styles.css         # Stilmall
├── init.sql               # Databasstruktur
├── Dockerfile            # Docker-konfiguration
└── docker-compose.yml    # Docker Compose-konfiguration
```

## Teknisk information

- PHP 8.1
- MySQL 5.7
- Apache 2.4
- phpMyAdmin

## Säkerhet

- Lösenord hashas med PHP:s inbyggda password_hash()
- SQL-injection skyddas genom prepared statements
- XSS skyddas genom htmlspecialchars()