$(() => {
    let suchenButton = $("#dbaf-fahrplan-suchen");

    suchenButton.on("click", () => {

        // INPUTS
        let abfahrtsDatumInput = $("#dbaf-abfahrts-datepicker");
        let ankunftsDatumInput = $("#dbaf-ankunfts-datepicker");

        let abfahrtsStationInput = $("#dbaf-station-picker");
        let ankunftsStationInput = $("#dbaf-ankunfts-station-picker");
     

        let spinner = "fas fa-spinner fa-spin";
        let iconElement = suchenButton.find("i");
        let aktuellesIcon = iconElement.prop("class");

        let baseURL = "https://v5.db.transport.rest/journeys";


        // VALUES
        let abfahrtStation = abfahrtsStationInput.val().replace(" ", "%20");
        let ankunftStation = ankunftsStationInput.val().replace(" ", "%20");
        let abfahrtDatum = abfahrtsDatumInput.val();
        let ankunftDatum = ankunftsDatumInput.val();

        // URL BAUEN
        let queryURL = baseURL + `?from=${abfahrtStation}&to=${ankunftStation}`;

        iconElement.removeClass(aktuellesIcon).addClass(spinner);

        $.ajax({
            type: "GET",
            url: "url",
            data: "data",
            dataType: "json",
            async: true,
            success: (response) => {
                iconElement.removeClass(spinner).addClass(aktuellesIcon);
            },
            error: () => {
                console.log("ERROR");
                iconElement.removeClass(spinner).addClass(aktuellesIcon);
            }
        });

    })
})