/*
    dbaf.js
    -------
    Beinhaltet alle Konstanten bzw. Einstellungen, welche für alle Seiten nötig sind.
*/

// Bei Deaktivierung oder anderweitiger Umgehung dieses Wertes und MAX_REQUEST_COUNT übernehmen wir keine Verantwortung,
// wenn Seiten nicht mehr richtig laden o.Ä., da die von der API maximal unterstützte Anfragenanzahl pro Minute überschritten wird
const LIMIT_REQUEST_COUNT = true; 

// Maximale Anfragen pro Minute, laut der genutzten API
const MAX_REQUEST_COUNT = 100; 

// Zählung der Anfragenanzahl
let CURR_REQUEST_COUNT = 0;

// Timer einrichten, welcher alle 60 Sekunden die Anfragen-Anzahl zurücksetzt
if (LIMIT_REQUEST_COUNT) {
    setInterval(function () {
        CURR_REQUEST_COUNT = 0;
    }, 60000);
}

// Sprache automatisch einstellen
DevExpress.localization.locale(navigator.language);
// dunkles Theme setzen
DevExpress.ui.themes.current('generic.dark');