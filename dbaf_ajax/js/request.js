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
                        "Name": value.name,
                        "Bundesland": value.federalState,
                        "Stadt": value.address.city,
                        "PLZ": value.address.zipcode,
                        "Straße": value.address.street
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