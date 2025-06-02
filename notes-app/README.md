Detta är en enkel README som jag skrivit själv för att beskriva hur min applikation fungerar.

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
1. Gå till sidan för att registrera dig.
2. Fyll i önskat användarnamn och lösenord.
3. Klicka på "Registrera".

### Inloggning
1. Gå till inloggningssidan.
2. Ange ditt användarnamn och lösenord.
3. Klicka på "Logga in".

### Hantera anteckningar
- Skapa ny anteckning: Klicka på knappen "Lägg till ny anteckning".
- Redigera anteckning: Klicka på "Redigera" bredvid anteckningen du vill ändra.
- Ta bort anteckning: Klicka på "Ta bort" bredvid anteckningen du vill ta bort (du kommer att få bekräfta).

## Projektstruktur

```
notes-app/
├── src/                    # Här är all källkod
│   ├── includes/          # Hjälpfunktioner och koppling till databasen
│   ├── index.php          # Startsidan efter inloggning
│   ├── login.php          # Sidan för inloggning
│   ├── register.php       # Sidan för att registrera sig
│   └── styles.css         # Utseendet på sidan
├── init.sql               # Hur databasen ska se ut från början
├── Dockerfile            # Inställningar för Docker-behållaren
└── docker-compose.yml    # Hur Docker ska köra appen
```

## Teknisk information

- PHP 8.1
- MySQL 5.7
- Apache 2.4
- phpMyAdmin

## Säkerhet

- Lösenord sparas inte i klartext, de "hashas" med en funktion i PHP.
- Försöker förhindra att någon kan skicka in skadlig kod via formulär (SQL-injection och XSS) genom att rensa input och använda säkra metoder för databasen.

Jag lär mig fortfarande och det här projektet hjälpte mig att förstå mer om hur PHP, Docker och databaser fungerar tillsammans.

Jag har försökt förklara projektet så tydligt jag kunde, och hoppas det är lätt att följa.