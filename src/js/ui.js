/*
    ui.js
    -----
    Beinhaltung aller Funktionen zur Veränderung von Elementen auf einer Oberfläche.
*/

/**
 * Funktion, um ein Element auf die gesamte Bildschirm-Fläche zu strecken
 * @param {String} ElementID 
 */
function StretchToClient(ElementID) {
    let iBodyHeight = Math.floor($("body").outerHeight(true));
    let iDocHeight = Math.floor($(window).outerHeight(true));
    let iMapHeight = Math.floor($(ElementID).height());
    let iTotalMapAvailableHeight = iDocHeight - (iBodyHeight - iMapHeight) - 40;

    // minimale Größe auf 500 Pixel begrenzen
    if (iTotalMapAvailableHeight < 500) {
        iTotalMapAvailableHeight = 500;
    }

    $(ElementID).height(iTotalMapAvailableHeight);
}

/**
 * Funktion, welches ein Element immer auf der maximalen Größe beibehält
 * @param {String} ElementID 
 */
function StickToClient(ElementID) {
    // warten, bis Element vollständig geladen wurde, falls es zur Initialisierung schon gestreckt werden sollte
    setTimeout(() => {
        StretchToClient(ElementID);
    }, 75);

    // bei Änderung der Client-Größe
    addEventListener("resize", (event) => {
        StretchToClient(ElementID);
    });
}