# EdzestervTracker

Ennek a weboldalnak a funkciója mások és saját konditermi edzésem kisegítése. 

Alapprobléma: konditermi edzésem során sokszor elveszett a rendszeresség, elfelejtettem, hol is tartok éppen, mit kellene csinálnom az egyenletes fejlődéshez.

Funkció: A weboldalra regisztráció után, hozzáadhatunk tetszőleges napra leosztott edzéstervet, elmenthetjük azt, majd nyomon követhetjük attól függően, hogy hol tartunk épp a héten, így lesz egy saját ellenőrzőnk.

Két mód között tudunk váltani: 
	manuális - itt a felhasználó saját részre hagyja jóvá, hogy túl van egy edzésen, így jelezheti az oldal számára, hogy léptethet
	automatikus - ha a felhasználó rendelkezik bérlettel az egri Cutler Fitness by Allure edzőterembe, bérletazonosítója megadásával automatikusan léptetheti az edzését, ilyenkor a program bérlet alapján lekérdezi annak státuszát, feldolgozza ha beléptette a rendszer az elmúlt ellenőrzés óta és automatikusan elváltja az edzését.

Az edzések, váltási módok bármikor módosíthatók, változtathatók, a felhasználók, adataik, bérlet adatok, illetve edzéstervek adatbázisban vannak eltárolva.

A weboldal valamely szinten reszponzív, főként mobil használatra van optimalizálva, főképp én és pár ismerősöm használta egy ingyenes webszerveren.

A projekt fejlesztése abbamaradt nemrégiben, így bizonyos funkciók nem feltétlen működnek tökéletesen, pl. időzített automatikus bérletfrissítés.