$(() => {
    $(window).on("load", () => {
        // let suchenButton = $("#dbaf-fahrplan-suchen");
        let suchenButton = $("#test");

        suchenButton.on("click", (event) => {

            console.log("start");

            event.stopPropagation();

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
            let abfahrtStation = abfahrtsStationInput.val().replace(" ", "+");
            let ankunftStation = ankunftsStationInput.val().replace(" ", "+");
            let abfahrtDatum = abfahrtsDatumInput.val();
            let ankunftDatum = ankunftsDatumInput.val();

            // URL BAUEN
            let queryURL = baseURL + `?from.address=${abfahrtStation}&to.address=${ankunftStation}`;

            iconElement.removeClass(aktuellesIcon).addClass(spinner);
            setTimeout(console.log(queryURL), 200);
            iconElement.removeClass(spinner).addClass(aktuellesIcon);

            // $.ajax({
            //     type: "GET",
            //     url: "url",
            //     data: "data",
            //     dataType: "json",
            //     async: true,
            //     success: (response) => {
            //         iconElement.removeClass(spinner).addClass(aktuellesIcon);
            //     },
            //     error: (response) => {
            //         console.log(`ERROR ${response.statusCode}: ${response.message}`);
            //         iconElement.removeClass(spinner).addClass(aktuellesIcon);
            //     }
            // });

        })
    })
})