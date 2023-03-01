$(window).on("load", () => {

    let toggler = $("#dbaf-date-toggler");

    let abfahrtsDatumInput = $("#dbaf-abfahrts-datepicker");

    let ankunftsDatumInput = $("#dbaf-ankunfts-datepicker");
    let ankunftsDatumLabel = $("#dbaf-ankunfts-datepicker-label");

    let todayButtonAbfahrt = $("#dbaf-today-btn-abfahrt");
    let todayButtonAnkunft = $("#dbaf-today-btn-ankunft");

    // Setzt das Datum auf den aktuellen Tag im Inputfeld
    todayButtonAbfahrt.on("click", () => { abfahrtsDatumInput.val(DateFormatter.FormattedDate); });
    todayButtonAnkunft.on("click", () => { ankunftsDatumInput.val(DateFormatter.FormattedDate); });

    // Togglet die sichtbarkeit der Input-Gruppe zum Ankunftsdatum
    toggler.on("change", () => {
        ToggleVisibility(ankunftsDatumInput);
        ToggleVisibility(ankunftsDatumLabel);
        ToggleVisibility(todayButtonAnkunft);
    });
});

/**
 * Ändert den Sichtbarkeitsstatus des Elements in das jeweils andere (an/aus -> aus/an)
 * @param {*} selector Das Jquery Objekt
 * @param {Boolean} isRequiredField Gibt an, ob das Feld ein bedingt benötigtes Formularfeld sein soll/ist
 */
function ToggleVisibility(selector, isRequiredField){
    
    let isHidden = selector.is(":hidden");
    let isFieldRequired = selector.is(":required");

    // Entfernen des intitalen required Tags -> wird beim toggleln richtig gesetzt
    if(isFieldRequired){
        selector.prop("required", false);
    }

    if(isRequiredField){

        return (isHidden) ? selector.show().prop("required", true) : selector.hide().prop("required", false);
    }

    return (isHidden) ? selector.show() : selector.hide();
}


/**
 * Formattierer-Hilfsobjekt zur richtigen Zeitformattierung
 * 
 */
const DateFormatter = {
    date: "",
    get FormattedDate(){
        if(this.date === ""){
            this.date = new Date();
        }

        let today = this.date;

        let year = today.getUTCFullYear();
        let month = today.getUTCMonth("de");

        // Addiere 1 auf Monatszahl herauf, um richtigen Monat zu erhalten 
        // -> benötigt, da getUTCMonth() darauf abzielt die herauskommende Zahl zum Mapping des Monats-Strings zu benutzen  
        month = parseInt(month) + 1;
        month = month.toString();

        if(month.length === 1){
            month = `0${month}`;
        }

        let day = today.getUTCDate().toString();
        if(day.length === 1){
            day = `0${day}`;
        }
        let time = today.toLocaleTimeString("de").slice(0, 5); // Sekunden entfernen, da nicht benötigt

        return `${year}-${month}-${day}T${time}`;
    }
}