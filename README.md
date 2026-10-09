# Webová knižnica gitarových akordov a tabulatúr

Lukáš Bíro

Študijná skupina: 5ZYI34

## Stručný opis projektu
Aplikácia slúži ako nezávislé, vlastnoručne hostované webové úložisko na organizáciu gitarového repertoáru. Rieši problém závislosti hudobníkov na komerčných aplikáciách s predplatným modelom a poskytuje im priestor na ukladanie a prispôsobovanie zjednodušených aranžmánov (napr. piesní zameraných výlučne na otvorené akordy bez zložitejších barre hmatov).

Cieľovou skupinou sú začínajúci a mierne pokročilí gitaristi, ktorí potrebujú rýchly a centralizovaný prístup k svojim tabulatúram bez rušivých elementov. Hlavným účelom je umožniť používateľom vyhľadávať, filtrovať a bezpečne ukladať hudobné dáta, pričom systém podporuje aj integráciu metadát z externých hudobných API.

## Role v projekte
#### Návštevník (neregistrovaný používateľ):
Má základné oprávnenia iba na čítanie. Bezpečné prehliadanie verejnej časti knižnice.
#### Gitarista (registrovaný používateľ):
Má oprávnenia na interakciu s obsahom. Zodpovedá za správu svojho osobného profilu a ukladanie obľúbených piesní do cvičných zoznamov.

#### Správca (admin):
Má plné admistrátorské oprávnenia na všetky CRUD operácie nad hlavnými entitami. Zodpovedá za kvalitu obsahu, nahrávanie nových interpretov a piesní, pridávanie súborov, kategorizáciu.

## Prípady použitia podľa rolí
#### Návštevník:
Návštevník vyhľadá produkt, v tomto prípade pieseň alebo interpreta z verejnej databázy. Návštevník filtruje zoznam piesní podľa náročnosti (napr. len "open chords").
#### Gitarista:
Používateľ sa prihlási do svojho účtu a upraví si používateľský profil. Používateľ si pridá vybranú pieseň do zoznamu obľúbených skladieb.
#### Správca:
Správca upraví ponuku piesní a pridá nového interpreta s využitím externého API na načítanie metadát. Správca nahrá k piesni sprievodný súbor (napr. PDF s podrobnou tabulatúrou). Správca zmaže alebo upraví nesprávne naformátované akordy v piesni.

## Plánované entity
#### Používateľ (User):
Udržiava informácie o registrovaných subjektoch. Atribúty: ID, e-mail, zahashované heslo, rola, profilový obrázok. Vzťah: 1:N k obľúbeným piesňam.
#### Interpret (Artist):
Združuje piesne podľa ich autorov. Atribúty: ID, meno/názov, bio, odkaz na obrázok. Vzťahy: 1:N k entite Pieseň.
#### Pieseň (Song):
Hlavná entita obsahujúca hudobné dáta. Atribúty: ID, názov, text s akordmi, obtiažnosť, odkaz na PDF súbor, interpret_ID. Vzťahy: 1:N k Interpretovi, M:N k Značkám.
#### Značka (Tag):
Kategorizuje piesne pre jednoduchšie vyhľadávanie (napr. "No Barre", "90s Rock"). Atribúty: ID, názov. Vzťahy: M:N k entite Pieseň.

## Vzťahy medzi entitami
#### Vzťah 1:N (Interpret : Pieseň):
Jeden interpret môže mať v databáze priradených viacero piesní, no každá konkrétna pieseň patrí práve jednému hlavnému interpretovi.
#### Vzťah M:N (Pieseň : Značka):
Jedna pieseň môže byť označená viacerými značkami (napr. "Nirvana" aj "Open Chords") a zároveň jedna značka môže byť priradená mnohým piesňam. Tento vzťah bude v databáze dekomponovaný asociačnou tabuľkou (napr. `song_tags`).

## Hlavné stránky aplikácie
#### Domovská stránka (Dashboard):
Vstupný bod aplikácie zobrazujúci najnovšie pridané piesne, štatistiky knižnice a rýchle vyhľadávanie.
#### Katalóg interpretov a piesní:
Stránka na prezeranie celej knižnice s pokročilým AJAX filtrovaním a stránkovaním záznamov.
#### Detail piesne:
Samostatná obrazovka pre konkrétnu skladbu, ktorá zobrazuje text s akordmi, prehrávač alebo stiahnuteľné PDF súbory.
#### Admistrátorské rozhranie (Správa entít):
Stránka prístupná iba pre správcu, obsahujúca formuláre na vytváranie, úpravu a mazanie (CRUD) interpretov a piesní, chránená na strane servera aj klienta.
#### Používateľský profil:
Obrazovka pre registrovaného používateľa, kde si môže zmeniť heslo, nahrať avatar a spravovať svoj zoznam obľúbených piesní.
#### Autentifikačná stránka:
Formuláre pre bezpečné prihlásenie a registráciu s validáciou vstupov.

## Rozdelenie funkcionality
#### Základné funkcie:
Komunikácia medzi klientskou a serverovou časťou vo frameworku VAJKO, databázový návrh v požadovanej kvalite (min. 3 entity, relačné väzby), implementácia používateľských rolí, autorizácia, aspoň 2 druhy AJAX volaní, spustiteľnosť v prostredí Docker.
#### Rozširujúce funkcie:
Vývoj používateľského rozhrania (SPA) pomocou frameworku React, asynchrónne volania na externé hudobné API (napríklad Songsterr alebo Spotify) pre automatické dopĺňanie metadát, implementácia in-place úpravy akordov priamo v tabuľke, pokročilá klientska validácia, prepracovaný responzívny dizajn.