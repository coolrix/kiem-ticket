

## Over Kiem-Ticket

Gemaakt met **Laravel**. 

- [Laravel](https://laravel.com).

## De opdracht

### Doel van de opdracht
- Demonstreren van je kennis van PHP en het Laravel framework.
- Evalueren van je begrip van MVC-architectuur en best practices in webontwikkeling.
- Testen van je vermogen om functionele en schaalbare webapplicaties te ontwikkelen.
### Opdracht
- Maak een nieuwe Laravel-applicatie met een formulier waarmee klanten de volgende informatie
- kunnen invoeren:
  1. Naam van de klant
  2. E-mailadres van de klant
  3. Kassaticket (bestand om te uploaden > alleen png, jpg, pdf)
- Implementeer een backend-functie om het formulier te verwerken en de geüploade kassatickets
veilig op te slaan. Zorg ervoor dat er een unieke bestandsnaam wordt gegenereerd.
- Voer validaties uit om ervoor te zorgen dat het formulier correct is ingevuld. Controleer
bijvoorbeeld of alle velden zijn ingevuld en of het geüploade bestand een geldig
kassaticketformaat heeft.
- Toon een bevestigingsbericht aan de gebruiker na een succesvolle upload en sla de
nodige gegevens op in de database.
- Denk ook na over beveiligingsmaatregelen en optimalisaties die je zou kunnen
implementeren.
- Documenteer ook je code en geef aan waarom je bepaalde keuzes hebt gemaakt.
- Maak gebruik van Bootstrap.
- Optioneel: Zorg voor een beveiligde pagina waarop alle ingestuurde tickets te zien zijn.
Zorg dat hier gegevens aangepast kunnen worden en dat er gezocht kan worden op naam
en e-mail. Deze pagina is enkel beschikbaar voor onze interne werking.
### Beoordelingscriteria
- Correctheid en volledigheid van de functionaliteit.
- Codekwaliteit en naleving van best practices.
- Netheid en leesbaarheid van de code.
- Gebruik van Laravel-specifieke functies en mogelijkheden.
- Gebruik van versiebeheer (Git) tijdens de ontwikkeling van de applicatie.
### Inleverinstructies
- Bezorg ons al jouw bestanden zodat we de opdracht kunnen bekijken en opspinnen.
- Optioneel: Plaats de code van je project in een publiekelijke GitHub-repository en deel
de link met ons.
- Optioneel: Voeg een README.md bestand toe met instructies voor het opzetten en
draaien van de applicatie, evenals eventuele toelichtingen of opmerkingen over je
implementatie.
- Een werkende demo-omgeving is altijd een goed idee.

## Installeren

#### Stap 1:
Neem het zip bestand met de projectbestanden.

#### Stap 2: 
Upload de gecomprimeerde bestanden naar je (sub)domein

#### Stap 3: Unzip de projectbestanden in de map van je (sub)domein

#### Stap 4: 
Pas de bestandspaden aan in index.php. Open het bestand index.php in de public map van je (sub)domein om het te bewerken. 
		Pas de bestandspaden aan om te verwijzen naar de juiste locatie van het maintenance.php bestand van je Laravel-toepassing. 
		Pas de volgende regel aan: 
        ```
        if (file_exists($maintenance = DIR.'/../storage/framework/maintenance.php')) 
        ```
		naar:
        ```
        if (file_exists($maintenance = DIR.'/storage/framework/maintenance.php')) 
        ```
		Deze wijziging zorgt ervoor dat Laravel het maintenance.php bestand kan vinden. Doe hetzelfde voor de andere paden

#### Stap 5: 
Kopieer alle bestanden en mappen uit de publieke map  naar de root-map van de projectbestanden van je (sub)domein. 
		Dit zorgt ervoor dat het Laravel-bestand index.php toegankelijk is via het web.

#### Stap 6: 
Wijzig het .env-bestand of maak een .env aan. Je kan het .env.example als voorbeeld nemen om mee te beginnen.
		Open het .env bestand in de root-map van je Laravel-toepassing en pas de variabelen aan zodat ze overeenkomen met je hostingomgeving. 
		Dit moet gebeuren voor de instellingen van de databaseverbinding, application-URL en andere configuratievariabelen 
		die relevant zijn voor je implementatie.

#### Stap 7: 
Test je Laravel-toepassing.
		Nadat je de implementatiestappen hebt voltooid en wijzigingen hebt aangebracht in het .env bestand, is het tijd om je 
		Laravel-toepassing te testen. Open je (sub)domein-url in een webbrowser om te controleren of de toepassing correct werkt. 
		Zorg ervoor dat alle pagina's, routes en functionaliteiten goed werken.

## Contacteer Mij

- **[Rik Dessers](mailto:rik@rikdessers.be)**
