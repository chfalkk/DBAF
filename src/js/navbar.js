// TODO: Darkmode

$(document).on("ready", () => {
    
    let toggler = $("#dbaf-darkmode-toggle");
    toggler.on("click", ToggleColorScheme());

})


/**
 * Toggelt das Farbschema des Webfrontends 
 * dunkel -> hell oder 
 * hell -> dunkel
 */
function ToggleColorScheme(){

    let toggler = $("#dbaf-darkmode-toggle");
    console.log(toggler);

}