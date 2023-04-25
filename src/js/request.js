/*
    request.js
    ----------
    Beinhaltet alle Funktionen zur Ausführung von Anfragen an die API.
*/

/**
 * URL für die API
 */
const API_URL = "https://v6.db.transport.rest";

/**
 * Klasse, um Anfragen an die API zu senden
 */
class DBAF_Request {
    StatusCode;
    Data;

    /**
     * Konstruktor für eine API-Anfrage.
     * Daten werden in der OnSuccess-Methode zurückgeliefert
     * 
     * @param {String} RequestParam 
     * @param {Boolean} Async True: wird nebenbei ausgeführt, ohne das der Hauptthread durch die Anfrage blockiert wird, False: wird synchron ausgeführt, d.h. alle anderen Prozesse werden blockert (z.B. die Anzeige wird nicht mehr aktualisiert)
     * @param {(StatusCode: number, Data: object)} [OnSuccess=] Methode, welche bei Erfolg aufgerufen wird und den StatusCode inklusive aller Daten durchreicht
     */
    constructor(RequestParam, Async, OnSuccess) {
        // maximale Abfrage-Anzahl pro Minute prüfen
        if (LIMIT_REQUEST_COUNT) {
            if (CURR_REQUEST_COUNT >= MAX_REQUEST_COUNT) {
                // maximale Anfragen überschritten -> Nachricht anzeigen
                $(() => {
                    DevExpress.ui.notify("Es können keine weiteren Anfragen verarbeitet werden!", "error", 500);
                });

                return;
            }
        }

        CURR_REQUEST_COUNT++;

        // Anfrage mit Hilfe von Ajax abschicken
        $.ajax({
            type: "GET",
            url: API_URL + RequestParam,
            dataType: "application/json",
            async: Async,
            complete: (response) => {
                // Abgeschlossen
                this.StatusCode = response.status;

                if (this.StatusCode != 200) {
                    // Fehler
                    console.log(`DBAF-Request Fehler ${response.status} (${API_URL + RequestParam})`);
                } else {
                    // Erfolg bei HTTP 200

                    try {
                        // Ergebnis parsen
                        this.Data = JSON.parse(response.responseText);
                    } catch (Exception) {
                        this.Data = null;
                    }

                    if (OnSuccess != null) {
                        // OnSuccess-Methode ausführen
                        OnSuccess(this.StatusCode, this.Data);
                    }
                }
            }
        });
    }
}

/**
 * Prüfen, ob die API verfügbar ist.
 * 
 * @returns {Boolean} Verfügbarkeit der API
 */
function IsAPIAvailable() {
    let bResult = false;

    let qry = new DBAF_Request("/", false, (StatusCode, Data) => {
        // Erfolg der Anfrage
        bResult = true;
    });

    return bResult;
}

// Status abfragen und bei Ausfall eine Warnung ausgeben
if (!IsAPIAvailable()) {
    $(() => {
        DevExpress.ui.notify("Die API ist zurzeit nicht verfügbar! Versuche es später erneut.", "error", 1000);
    });
}

/**
 * Konstante für alle Bundesländer
 */
const FEDERALSTATE_ANY = "Alle";

/**
 * Array mit allen Bundesländern
 */
const FEDERALSTATES = [
    "Baden-Württemberg",
    "Bayern",
    "Berlin",
    "Brandenburg",
    "Bremen",
    "Hamburg",
    "Hessen",
    "Mecklenburg-Vorpommern",
    "Niedersachsen",
    "Nordrhein-Westfalen",
    "Rheinland-Pfalz",
    "Saarland",
    "Sachsen",
    "Sachsen-Anhalt",
    "Schleswig-Holstein",
    "Thüringen"
];

/**
 * Array mit allen Bundenländern, einschließlich dem String "Alle"
 */
const EXT_FEDERALSTATES = [FEDERALSTATE_ANY].concat(FEDERALSTATES);

/**
 * Bahnhöfe in Abhängigkeit des Bundeslandes abholen.
 * 
 * @param {String} FederalState 
 * @param {([] | null)} [OnSuccess=] Methode, welche bei Erfolg aufgerufen wird
 * @returns {[]} Array mit allen Stationen von der API
 */
function GetAllStations(FederalState, OnSuccess = null) {
    let aStations = [];
    let aIDs = [];

    // alle Daten laden
    let qry = new DBAF_Request("/stations", true, (StatusCode, Data) => {
        let bFilter = FederalState != FEDERALSTATE_ANY;
    
        for (const [key, value] of Object.entries(Data)) {
            // Daten zum Ergebnis hinzufügen (ohne doppelte IDs)
            if (!aIDs.includes(value.id)) {
                // Filterung nach dem Bundesland
                if (bFilter && value.federalState != FederalState) {
                    continue;
                }

                let iLongitude = null;
                let iLatitude = null;

                // Koordinaten auslesen
                if (value.location != null) {
                    iLongitude = value.location.longitude;
                    iLatitude = value.location.latitude;
                }

                let bSteplessAccess = (value.hasSteplessAccess == "yes" ? true : false);

                aStations.push({
                    "ID": value.id,
                    "name": value.name, // Stationsname
                    "federalState": value.federalState, // Bundesland
                    "city": value.address.city, // Stadt
                    "zipcode": value.address.zipcode, // PLZ
                    "street": value.address.street, // Straße
                    "locLatitude": iLongitude, // Latitude (Breitengrad)
                    "locLongitude": iLatitude, // Longitude (Längengrad)
                    "hasSteplessAccess": bSteplessAccess // Stufenloser Eingang
                });
                aIDs.push(value.id);
            }
        }

        // OnSuccess ausführen
        if (OnSuccess != null) {
            OnSuccess(aStations);
        }
    });

    return aStations;
}

/**
 * Alle Abfahrten von einem Bahnhof an einem Datum abholen.
 * 
 * @param {number} StationID 
 * @param {Date} TargetDate 
 * @param {([] | null)} [OnSuccess=] Methode, welche bei Erfolg aufgerufen wird
 * @returns {[]} Array mit allen Ankünften an einer Station
 */
function GetAllDepartures(StationID, TargetDate, OnSuccess = null) {
    let aDepartures = [];
    let i24h = 60 * 23 + 59; // 23 Std., 59 Min. (der ganze Tag)

    TargetDate.setHours(0, 0, 0);
    TargetDate.setMilliseconds(0);

    // alle Daten laden
    let qry = new DBAF_Request("/stops/" + StationID + "/departures?results=10000&when=" + TargetDate.toISOString() + "&duration=" + i24h + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data.departures) {
            aDepartures.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen, // geplante Abfahrt
                "when": item.when, // wirkliche Abfahrt
                "direction": item.direction, // Richtung
                "plannedPlatform": item.plannedPlatform, // geplante Plattform
            });
            i++;
        }  

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess(aDepartures);
        }
    });

    return aDepartures;
}

/**
 * Alle Ankunften von einem Bahnhof an einem Datum abholen.
 * 
 * @param {number} StationID 
 * @param {Date} TargetDate 
 * @param {([] | null)} [OnSuccess=] Methode, welche bei Erfolg aufgerufen wird
 * @returns {[]} Array mit allen Ankünften an einer Station
 */
function GetAllArrivals(StationID, TargetDate, OnSuccess = null) {
    let aArrivals = [];

    TargetDate.setHours(0, 0, 0);
    TargetDate.setMilliseconds(0);

    // alle Daten laden
    let qry = new DBAF_Request("/stops/" + StationID + "/arrivals?results=10000&when=" + TargetDate.toISOString() + "&duration=" + 60*23+59 + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data.arrivals) {
            aArrivals.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen, // geplante Ankunft
                "when": item.when, // wirkliche Ankunft
                "provenance": item.provenance, // Ursprung
                "plannedPlatform": item.plannedPlatform, // geplante Plattform
            });
            i++;
        }  

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess(aArrivals);
        }
    });

    return aArrivals;
}

/**
 * Konvertierung von Minuten zu Stunden und Minuten als String.
 * 
 * @param {number} Minutes 
 * @param {Boolean} ShowZero Bestimmt, ob Null-Wert zurückgegeben werden darf 
 * @returns {String} Stunden und Minuten als String 
 */
function ConvertMinutesToStr(Minutes, ShowZero) {
    let iHours = 0;

    if (Minutes < 0) {
        return "";
    } 

    if (Minutes == 0 && !ShowZero) {
        return "";
    }

    while (Minutes >= 60) {
        Minutes-=60;
        iHours++;
    }

    return iHours + " Stunde(n), " + Minutes + " Minute(n)";
}

/**
 * Alle Trips von einem Startpunkt zu einem Endpunkt ab einer bestimmten Zeit abholen.
 * 
 * @param {number} StartStationID 
 * @param {number} EndStationID 
 * @param {Date} StartDateTime Datum und Uhrzeit, ab wann die nächstmögliche Abfahrt möglich sein sollte. 
 * @param {([] | null)} [OnSuccess=] Methode, die bei Erolg aufgerufen wird. (Preis ist null, wenn er nicht ermittelt werden konnte)
 * @returns {[]} Array mit allen Zwischenstop-Daten
 */
function GetAllJourneys(StartStationID, EndStationID, StartDateTime, OnSuccess = null) {
    // Start- und Endstation dürfen nicht übereinstimmen
    if (StartStationID == EndStationID) {
        return;
    }

    let aJourneys = [];
    let aData = [];

    // alle Daten laden
    let qry = new DBAF_Request("/journeys?from=" + StartStationID + "&to=" + EndStationID + "&departure=" + StartDateTime.toISOString() + "&transfers=1000&results=1&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {
        let aJourney = Data.journeys[0];
        let i = 0;

        // Preis abholen
        let dPrice = null;
        if (aJourney.price != null) {
            dPrice = aJourney.price.amount;
        }

        // komplette Wartezeit und Trip-Zeit berechnen
        let iTotalWaitingMins = 0;
        let iTotalTripMins = 0;

        for (aStop of aJourney.legs) {
            // Start- und Endzeit ermitteln
            let dStartDate = new Date(aStop.departure);
            let dEndDate = new Date(aStop.arrival);

            // Benötigte Trip-Zeit berechnen
            let iTripMins = (dEndDate.getTime() - dStartDate.getTime()) / 1000 / 60;
            iTotalTripMins += iTripMins;

            // Linien-Name abholen
            let sLineName = "";
            if (aStop.line != null) {
                sLineName = aStop.line.name;
            } else {
                sLineName = "Zu Fuß"
            }

            // Wartezeit vom letzten Stop zur Abfahrt an diesem Stop berechnen
            let iWaitingMins = 0;
            if (i > 0) {
                let aLastStop = aJourney.legs[i - 1];

                // Zeit zwischen Abfahrt an diesem Stop und Ankunft an letztem Stop berechnen
                let dLastStopArrival = new Date(aLastStop.arrival);
                let dCurrentStopDeparture = new Date(aStop.departure);

                iWaitingMins = (dCurrentStopDeparture.getTime() - dLastStopArrival.getTime()) / 1000 / 60;
                iTotalWaitingMins+= iWaitingMins;
            }

            // Daten zum Result hinzufügen
            aJourneys.push({
                "ID": "" + i,
                "startStation": aStop.origin.name, // Start-Station eines Trips
                "endStation": aStop.destination.name, // End-Station eines Trips
                "timeStart": dStartDate, // Startzeit
                "timeEnd": dEndDate, // Endzeit
                "line": sLineName, // Linien-Name
                "timeWaiting": ConvertMinutesToStr(iWaitingMins, false), // Wartezeit, bis zum Start
                "timeTrip": ConvertMinutesToStr(iTripMins, false) // Fahrt-/Laufzeit
            });
            i++;
        }  

        aData = ({
            "journeys": aJourneys, // Alle Trip-Daten
            "totalWaitingMins": iTotalWaitingMins, // gesamte Wartezeit zwischen Trips
            "totalTripMins": iTotalTripMins, // gesamte Fahrt-/Laufzeit
            "price": dPrice // Preis (sofern kalkulierbar)
        });

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess(aData);
        }
    });

    return aData;
}