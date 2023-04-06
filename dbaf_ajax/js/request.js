class DBAF_Request {
    StatusCode;
    Data;

    constructor(URL, Async, OnSuccess) {
        $.ajax({
            type: "GET",
            url: URL,
            dataType: "application/json",
            async: Async,
            complete: (response) => {
                // Abgeschlossen
                this.StatusCode = response.status;

                if (this.StatusCode != 200) {
                    // Fehler
                    console.log(`DBAF-Request Fehler ${response.status} (${URL})`);
                } else {
                    // Erfolg
                    this.Data = JSON.parse(response.responseText);
                    OnSuccess(this.StatusCode, this.Data);
                }
            }
        });
    }
}

/**
 * Alle Bahnhöfe abholen
 */
function GetAllStations(OnSuccess = null) {
    let aStations = [];
    let aIDs = [];

    // alle Daten laden
    let qry = new DBAF_Request("https://v5.db.transport.rest/stations", true, (StatusCode, Data) => {
        if (StatusCode == 200) {
            for (const [key, value] of Object.entries(Data)) {
                // Daten zum Ergebnis hinzufügen (ohne doppelte IDs)
                if (!aIDs.includes(value.id)) {
                    aStations.push({
                        "ID": value.id,
                        "name": value.name,
                        "federalState": value.federalState,
                        "city": value.address.city,
                        "zipcode": value.address.zipcode,
                        "street": value.address.street
                    });
                    aIDs.push(value.id);
                }
            }

            // OnSuccess ausführen
            OnSuccess();
        } 
    });

    return aStations;
}

/**
 * Alle Abfahrten von einem Bahnhof an einem Datum abholen
 */
function GetAllDepartures(StationID, TargetDate, OnSuccess = null) {
    let aDepartures = [];

    TargetDate.setHours(0, 0, 0);
    TargetDate.setMilliseconds(0);

    // alle Daten laden
    let qry = new DBAF_Request("https://v5.db.transport.rest/stops/" + StationID + "/departures?results=10000&when=" + TargetDate.toISOString() + "&duration=" + 60*23+59 + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data) {
            aDepartures.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen,
                "when": item.when,
                "direction": item.direction,
                "plannedPlatform": item.plannedPlatform,
                "elevator": "TODO"
            });
            i++;
        }  

        // OnSuccess aufrufen
        OnSuccess();
    });

    return aDepartures;
}

/**
 * Alle Ankunften zu einem Bahnhof an einem Datum abholen
 */
function GetAllArrivals(StationID, TargetDate, OnSuccess = null) {
    let aArrivals = [];

    TargetDate.setHours(0, 0, 0);
    TargetDate.setMilliseconds(0);

    // alle Daten laden
    let qry = new DBAF_Request("https://v5.db.transport.rest/stops/" + StationID + "/arrivals?results=10000&when=" + TargetDate.toISOString() + "&duration=" + 60*23+59 + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data) {
            aArrivals.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen,
                "when": item.when,
                "provenance": item.provenance,
                "plannedPlatform": item.plannedPlatform,
                "elevator": "TODO"
            });
            i++;
        }  

        // OnSuccess aufrufen
        OnSuccess();
    });

    return aArrivals;
}