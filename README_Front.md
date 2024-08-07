## De bestanden die nodig zijn voor de database

1. seeder.php
2. house.php
3. user.php
4. rented.php
5. reviews.php
6. house_image.php

## De bestanden die nodig zijn voor de api
### Dit staat in de api map

1. connection.php (deze staat niet in de api map deze staat los)
2. houseimg_api.php
3. houses_api.php
4. rented_api.php
5. reviews_api.php
6. user_api.php
7. search_api.php
8. house_availability_api.php
9. house_review_api.php

Er zijn 5 CRUD (Create, Read, Update, Delete) api's geschreven met php, 1 voor de reviews dit is de reviews_api.php, 1 voor de huizen dit is de houses_api.php, 1 voor de verhuurde datums dit is de rented_api.php, 1 voor de plaatjes van het huis dit is de houseimg_api.php en 1 voor de users dit is de user_api.php. Doormiddel van javascript in de html kan de api aan geroepen worden. Let wel op dat je in het script de method mee geeft en natuurlijk aan de juiste api koppelen.

De api's maken connectie met de database door de connection.php en om de database aan te maken kan de seeder (seeder.php) gerund worden die maakt natuurlijk de database en dan heb je ook nog standaard huizen (house.php), plaatjes van een paar huizen (house_image.php), een paar verhuurde datums (rented.php), reviews en al wat gebruikers (user.php). De gegevens kunnen ook nog aan gepast worden of er bij gevoegd worden voordat de seeder gerund word.

Als alles is goed gegaan lezen de api's de informatie uit de database tabel waar hun aan gekoppelt zijn om zeker te weten dat alles is goed gegaan kan je ook de de api.php downloaden en openen als het goed is zie je dan allemaal informatie verder word deze niet meer gebruikt.

De CRUD api's kunnen data toevoegen door de POST method, alle gegevens van de tabel ophalen of 1 als er een id is meegegeven hier gebruik de GET method, informatie van een id updaten hierbij geef je de method PUT en data verwijderen de method hiervoor is DELETE.

De search_api.php pakt de gegevens die je hebt geselecteerd om op te zoeken van welk huis je wilt en geeft terug wat er bij past.

De house_availibility_api.php kijkt wanneer de eerst volgende datum is wanneer het huis vrij is om geboekt te kunnen worden.

De house_review_api.php kijkt welke reviews er bij het huis hoord wat jij gekozen hebt en deze geeft alle reviews terug.