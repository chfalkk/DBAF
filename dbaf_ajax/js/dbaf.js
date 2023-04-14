/* DBAF-KONSTANTEN */

const LIMIT_REQUEST_COUNT = true; // Bei Deaktivierung oder anderweitiger Umgehung dieses Wertes übernehmen wir keine Konsequenzen,
// wenn Seiten nicht mehr richtig laden o.Ä., da die von der API maximal unterstützte Anfragenzahl überschritten wird 

const MAX_REQUEST_COUNT = 100; // Maximale Anfragen pro Minute, laut der genutzten API


/* EINSTELLUNGEN FÜR JEDE DBAF-SEITE EINRICHTEN */

// Timer einrichten, welcher alle 60 Sekunden die Anfragen-Anzahl zurücksetzt
let CURR_REQUEST_COUNT = 0;
let REQUEST_TIMER = null;
if (LIMIT_REQUEST_COUNT) {
    REQUEST_TIMER = setInterval(function () {
        CURR_REQUEST_COUNT = 0;
    }, 60000);
}

// Sprache automatisch einstellen
DevExpress.localization.locale(navigator.language);
// dunkles Theme setzen
DevExpress.ui.themes.current('generic.dark');