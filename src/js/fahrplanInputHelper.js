$(window).on("load", () => {

    let toggler = $("#dbaf-date-toggler");
    let ankunftsDatumInput = $("#dbaf-ankunfts-datepicker");
    let ankunftsDatumLabel = $("#dbaf-ankunfts-datepicker-label");


   toggler.on("change", () => {
    ToggleVisibility(ankunftsDatumInput);
    ToggleVisibility(ankunftsDatumLabel);
   })
});

/**
 * Ändert den Sichtbarkeitsstatus des Elements in das jeweils andere (an/aus -> aus/an)
 * @param {*} selector Das Jquery Objekt
 */
function ToggleVisibility(selector){
    
    let isHidden = selector.is(":hidden");

    (isHidden) ? selector.show() : selector.hide();
}