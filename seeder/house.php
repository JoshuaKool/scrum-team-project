<?php

require_once("../connection.php");

$stmt = $pdo->prepare("INSERT INTO `houses` (house_type, country, place, seller_id, price, rating, description, rooms, pets_allowed, parkingplace, accessible_disabled_people, smoking_allowed, garden, balcony)
    VALUES (:house_type, :country, :place, :seller_id, :price, :rating, :description, :rooms, :pets_allowed, :parkingplace, :accessible_disabled_people, :smoking_allowed, :garden, :balcony)");

$data = [
    ['flat', 'Duitsland', 'Frankfurt', 5, 120, 8.3, 'Chique flat in Frankfurt. Dicht bij zakendistricten.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Spanje', 'Madrid', 1, 140, 8.4, 'Stijlvol appartement in Madrid. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Spanje', 'Sevilla', 2, 220, 8.7, 'Ruime villa in Sevilla. Perfect voor familievakanties.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Spanje', 'Granada', 3, 130, 8.2, 'Gezellige flat in Granada. Dicht bij de Alhambra.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Portugal', 'Lissabon', 4, 150, 8.5, 'Modern appartement in Lissabon. Geweldig voor stedelijk leven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Portugal', 'Porto', 5, 240, 8.8, 'Luxe villa in Porto. Perfect voor familiebijeenkomsten.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brussel', 1, 110, 8.3, 'Gezellige flat in Brussel. Dicht bij het stadscentrum.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'België', 'Antwerpen', 2, 130, 8.4, 'Stijlvol appartement in Antwerpen. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'België', 'Gent', 3, 200, 8.7, 'Ruime villa in Gent. Perfect voor families.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brugge', 4, 120, 8.2, 'Charmante flat in Brugge. Dicht bij historische bezienswaardigheden.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Zweden', 'Stockholm', 5, 140, 8.5, 'Modern appartement in Stockholm. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Zweden', 'Göteborg', 1, 220, 8.8, 'Ruime villa in Göteborg. Perfect voor grote gezinnen.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Amsterdam', 2, 120, 8.3, 'Charmant rijtjeshuis in Amsterdam. Dicht bij de grachten.', 3, 'yes', 'no', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Rotterdam', 3, 140, 8.5, 'Modern rijtjeshuis in Rotterdam. Dicht bij het stadscentrum.', 4, 'yes', 'yes', 'no', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Den Haag', 4, 130, 8.4, 'Gezellig rijtjeshuis in Den Haag. Dicht bij het strand.', 3, 'no', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Utrecht', 5, 150, 8.6, 'Stijlvol rijtjeshuis in Utrecht. Geweldig voor families.', 4, 'yes', 'no', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Eindhoven', 1, 110, 8.2, 'Modern rijtjeshuis in Eindhoven. Dicht bij het stadscentrum.', 3, 'no', 'yes', 'no', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Maastricht', 2, 160, 8.7, 'Luxe rijtjeshuis in Maastricht. Perfect voor vakanties.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Leiden', 3, 130, 8.4, 'Charmant rijtjeshuis in Leiden. Dicht bij de universiteit.', 3, 'yes', 'no', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Nederland', 'Groningen', 4, 140, 8.5, 'Modern rijtjeshuis in Groningen. Geweldig voor studenten.', 4, 'yes', 'yes', 'no', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Tokio', 5, 120, 8.6, 'Traditionol huis in Tokio. Dicht bij de metro.', 2, 'no', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Kyoto', 1, 150, 8.8, 'Charmant huis in Kyoto. Dicht bij historische tempels.', 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Osaka', 2, 140, 8.5, 'Modern huis in Osaka. Geweldig voor gezinnen.', 3, 'no', 'no', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Hiroshima', 3, 130, 8.4, 'Gezellig huis in Hiroshima. Dicht bij het vredespark.', 3, 'yes', 'yes', 'no', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Nagoya', 4, 160, 8.7, 'Luxe huis in Nagoya. Perfect voor zakenreizigers.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Sapporo', 5, 150, 8.6, 'Stijlvol huis in Sapporo. Geweldig voor wintersporten.', 4, 'yes', 'no', 'yes', 'yes', 'yes', 'no'],
    ['rijtjeshuis', 'Japan', 'Kobe', 1, 120, 8.3, 'Charmant huis in Kobe. Dicht bij de haven.', 3, 'no', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Duitsland', 'Frankfurt', 2, 140, 8.4, 'Chique flat in Frankfurt. Dicht bij zakendistricten.', 3, 'yes', 'no', 'yes', 'no', 'no', 'yes'],
    ['appartment', 'Spanje', 'Madrid', 3, 160, 8.6, 'Stijlvol appartement in Madrid. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Spanje', 'Sevilla', 4, 250, 8.9, 'Ruime villa in Sevilla. Perfect voor familievakanties.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Spanje', 'Granada', 5, 130, 8.3, 'Gezellige flat in Granada. Dicht bij de Alhambra.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Portugal', 'Lissabon', 1, 150, 8.5, 'Modern appartement in Lissabon. Geweldig voor stedelijk leven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Portugal', 'Porto', 2, 240, 8.8, 'Luxe villa in Porto. Perfect voor familiebijeenkomsten.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brussel', 3, 120, 8.3, 'Gezellige flat in Brussel. Dicht bij het stadscentrum.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'België', 'Antwerpen', 4, 140, 8.4, 'Stijlvol appartement in Antwerpen. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'België', 'Gent', 5, 200, 8.7, 'Ruime villa in Gent. Perfect voor families.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brugge', 1, 120, 8.2, 'Charmante flat in Brugge. Dicht bij historische bezienswaardigheden.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Zweden', 'Stockholm', 2, 140, 8.5, 'Modern appartement in Stockholm. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Zweden', 'Göteborg', 3, 220, 8.8, 'Ruime villa in Göteborg. Perfect voor grote gezinnen.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Amsterdam', 4, 130, 8.4, 'Gezellige flat in Amsterdam. Dicht bij de grachten.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['appartment', 'Nederland', 'Rotterdam', 5, 150, 8.6, 'Stijlvol appartement in Rotterdam. Geweldig voor stadsleven.', 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'],
    ['villa', 'Nederland', 'Den Haag', 1, 220, 8.7, 'Luxe villa in Den Haag. Perfect voor familiebijeenkomsten.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Utrecht', 2, 110, 8.3, 'Gezellige flat in Utrecht. Dicht bij het stadscentrum.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Nederland', 'Eindhoven', 3, 130, 8.5, 'Stijlvol appartement in Eindhoven. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Nederland', 'Maastricht', 4, 160, 8.7, 'Ruime villa in Maastricht. Perfect voor vakanties.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Leiden', 5, 140, 8.6, 'Moderne flat in Leiden. Dicht bij de universiteit.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['appartment', 'Nederland', 'Groningen', 1, 120, 8.4, 'Charmant appartement in Groningen. Geweldig voor studenten.', 2, 'no', 'yes', 'no', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Tokio', 2, 150, 8.6, 'Traditionele villa in Tokio. Dicht bij historische tempels.', 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Japan', 'Kyoto', 3, 140, 8.5, 'Gezellige flat in Kyoto. Perfect voor stedelijk leven.', 3, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Japan', 'Osaka', 4, 130, 8.4, 'Modern appartement in Osaka. Geweldig voor zakelijke reizigers.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Hiroshima', 5, 160, 8.7, 'Luxe villa in Hiroshima. Perfect voor grote gezinnen.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Japan', 'Nagoya', 1, 150, 8.6, 'Chique flat in Nagoya. Dicht bij zakendistricten.', 3, 'yes', 'no', 'yes', 'no', 'no', 'yes'],
    ['appartment', 'Japan', 'Sapporo', 2, 120, 8.3, 'Stijlvol appartement in Sapporo. Geweldig voor wintersporten.', 2, 'no', 'yes', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Kobe', 3, 140, 8.5, 'Ruime villa in Kobe. Perfect voor familievakanties.', 4, 'yes', 'yes', 'no', 'yes', 'yes', 'no'],
    ['flat', 'Duitsland', 'Frankfurt', 4, 120, 8.3, 'Chique flat in Frankfurt. Dicht bij zakendistricten.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Spanje', 'Madrid', 5, 140, 8.4, 'Stijlvol appartement in Madrid. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Spanje', 'Sevilla', 1, 220, 8.7, 'Ruime villa in Sevilla. Perfect voor familievakanties.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Spanje', 'Granada', 2, 130, 8.2, 'Gezellige flat in Granada. Dicht bij de Alhambra.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Portugal', 'Lissabon', 3, 150, 8.5, 'Modern appartement in Lissabon. Geweldig voor stedelijk leven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Portugal', 'Porto', 4, 240, 8.8, 'Luxe villa in Porto. Perfect voor familiebijeenkomsten.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brussel', 5, 120, 8.3, 'Gezellige flat in Brussel. Dicht bij het stadscentrum.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'België', 'Antwerpen', 1, 140, 8.4, 'Stijlvol appartement in Antwerpen. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'België', 'Gent', 2, 200, 8.7, 'Ruime villa in Gent. Perfect voor families.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'België', 'Brugge', 3, 120, 8.2, 'Charmante flat in Brugge. Dicht bij historische bezienswaardigheden.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Zweden', 'Stockholm', 4, 140, 8.5, 'Modern appartement in Stockholm. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Zweden', 'Göteborg', 5, 220, 8.8, 'Ruime villa in Göteborg. Perfect voor grote gezinnen.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Amsterdam', 1, 130, 8.4, 'Gezellige flat in Amsterdam. Dicht bij de grachten.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['appartment', 'Nederland', 'Rotterdam', 2, 150, 8.6, 'Stijlvol appartement in Rotterdam. Geweldig voor stadsleven.', 4, 'yes', 'yes', 'no', 'yes', 'no', 'yes'],
    ['villa', 'Nederland', 'Den Haag', 3, 220, 8.7, 'Luxe villa in Den Haag. Perfect voor familiebijeenkomsten.', 6, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Utrecht', 4, 110, 8.3, 'Gezellige flat in Utrecht. Dicht bij het stadscentrum.', 2, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Nederland', 'Eindhoven', 5, 130, 8.5, 'Stijlvol appartement in Eindhoven. Geweldig voor stadsleven.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Nederland', 'Maastricht', 1, 160, 8.7, 'Ruime villa in Maastricht. Perfect voor vakanties.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Nederland', 'Leiden', 2, 140, 8.6, 'Moderne flat in Leiden. Dicht bij de universiteit.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['appartment', 'Nederland', 'Groningen', 3, 120, 8.4, 'Charmant appartement in Groningen. Geweldig voor studenten.', 2, 'no', 'yes', 'no', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Tokio', 4, 150, 8.6, 'Traditionele villa in Tokio. Dicht bij historische tempels.', 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Japan', 'Kyoto', 5, 140, 8.5, 'Gezellige flat in Kyoto. Perfect voor stedelijk leven.', 3, 'no', 'yes', 'no', 'no', 'no', 'yes'],
    ['appartment', 'Japan', 'Osaka', 1, 130, 8.4, 'Modern appartement in Osaka. Geweldig voor zakelijke reizigers.', 3, 'yes', 'no', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Hiroshima', 2, 160, 8.7, 'Luxe villa in Hiroshima. Perfect voor grote gezinnen.', 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'no'],
    ['flat', 'Japan', 'Nagoya', 3, 150, 8.6, 'Chique flat in Nagoya. Dicht bij zakendistricten.', 3, 'yes', 'no', 'yes', 'no', 'no', 'yes'],
    ['appartment', 'Japan', 'Sapporo', 4, 120, 8.3, 'Stijlvol appartement in Sapporo. Geweldig voor wintersporten.', 2, 'no', 'yes', 'yes', 'yes', 'no', 'yes'],
    ['villa', 'Japan', 'Kobe', 5, 140, 8.5, 'Ruime villa in Kobe. Perfect voor familievakanties.', 4, 'yes', 'yes', 'no', 'yes', 'yes', 'no'],
];



foreach ($data as $entry) {
    $stmt->bindParam(':house_type', $entry[0]);
    $stmt->bindParam(':country', $entry[1]);
    $stmt->bindParam(':place', $entry[2]);
    $stmt->bindParam(':seller_id', $entry[3]);
    $stmt->bindParam(':price', $entry[4]);
    $stmt->bindParam(':rating', $entry[5]);
    $stmt->bindParam(':description', $entry[6]);
    $stmt->bindParam(':rooms', $entry[7]);
    $stmt->bindParam(':pets_allowed', $entry[8]);
    $stmt->bindParam(':parkingplace', $entry[9]);
    $stmt->bindParam(':accessible_disabled_people', $entry[10]);
    $stmt->bindParam(':smoking_allowed', $entry[11]);
    $stmt->bindParam(':garden', $entry[12]);
    $stmt->bindParam(':balcony', $entry[13]);
    
    $stmt->execute();
}
?>