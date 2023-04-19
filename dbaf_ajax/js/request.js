/*
    request.js
    ----------
    Beinhaltet alle Funktionen zur Ausführung von Anfragen an die API.
*/

/**
 * URL für die API
 */
const API_URL = "https://v6.db.transport.rest";

// DBAF-TODO: Auskommentierung ab hier

class DBAF_Request {
    StatusCode;
    Data;

    constructor(URL, Async, OnSuccess) {
        // maximale Abfrage-Anzahl pro Minute prüfen
        if (LIMIT_REQUEST_COUNT) {
            if (CURR_REQUEST_COUNT > MAX_REQUEST_COUNT) {
                // maximale Anfragen überschritten
                $(() => {
                    DevExpress.ui.notify("Es können keine weiteren Anfragen verarbeitet werden!", "error", 400);
                });

                return;
            }
        }

        CURR_REQUEST_COUNT++;
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

                    if (OnSuccess != null) {
                        OnSuccess(this.StatusCode, this.Data);
                    }
                }
            }
        });
    }
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
 * Bahnhöfe in Abhängigkeit des Bundeslandes abholen
 */
function GetAllStations(FederalState, OnSuccess = null) {
    let aStations = [];
    let aIDs = [];

    // alle Daten laden
    let qry = new DBAF_Request(API_URL + "/stations", true, (StatusCode, Data) => {
        let bFilter = FederalState != FEDERALSTATE_ANY;
    
        for (const [key, value] of Object.entries(Data)) {
            // Daten zum Ergebnis hinzufügen (ohne doppelte IDs)
            if (!aIDs.includes(value.id)) {
                if (bFilter && value.federalState != FederalState) {
                    continue;
                }

                let iLongitude = null;
                let iLatitude = null;

                if (value.location != null) {
                    iLongitude = value.location.longitude;
                    iLatitude = value.location.latitude;
                }

                aStations.push({
                    "ID": value.id,
                    "name": value.name,
                    "federalState": value.federalState,
                    "city": value.address.city,
                    "zipcode": value.address.zipcode,
                    "street": value.address.street,
                    "locLatitude": iLongitude,
                    "locLongitude": iLatitude
                });
                aIDs.push(value.id);
            }
        }

        // OnSuccess ausführen
        if (OnSuccess != null) {
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
    let qry = new DBAF_Request(API_URL + "/stops/" + StationID + "/departures?results=10000&when=" + TargetDate.toISOString() + "&duration=" + 60*23+59 + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data.departures) {
            aDepartures.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen,
                "when": item.when,
                "direction": item.direction,
                "plannedPlatform": item.plannedPlatform,
                "elevator": "TODO" // DBAF-TODO: Fahrstuhlanzeige
            });
            i++;
        }  

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess();
        }
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
    let qry = new DBAF_Request(API_URL + "/stops/" + StationID + "/arrivals?results=10000&when=" + TargetDate.toISOString() + "&duration=" + 60*23+59 + "&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {  
        let i = 0;

        for (item of Data.arrivals) {
            aArrivals.push({
                "ID": "" + i,
                "plannedWhen": item.plannedWhen,
                "when": item.when,
                "provenance": item.provenance,
                "plannedPlatform": item.plannedPlatform,
                "elevator": "TODO"// DBAF-TODO: Fahrstuhlanzeige
            });
            i++;
        }  

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess();
        }
    });

    return aArrivals;
}

/**
 * Konvertierung von Minuten in einen String aus Stunden & Minuten
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
 * Formatierung von einem Datum zu einen String 
 */
function ConvertDateToStr(Date) {
    let iMinute = Date.getMinutes();
    let iHour = Date.getHours();
    let iDay = Date.getDate();
    let iMonth = Date.getMonth() + 1;
    let iYear = Date.getFullYear();

    let sMinute = iMinute < 10 ? '0' + iMinute : iMinute;
    let sHour = iHour < 10 ? '0' + iHour : iHour;
    let sDay = iDay < 10 ? '0' + iDay : iDay;
    let sMonth = iMonth < 10 ? '0' + iMonth : iMonth;

    return sDay + "." + sMonth + "." + iYear + " " + sHour + ":" + sMinute + " Uhr";
}

/**
 * Alle Trips von einem Startpunkt zu einem Endpunkt ab einer bestimmten Zeit abholen 
 */
function GetAllJourneys(StartStationID, EndStationID, StartDateTime, OnSuccess = null) {
    if (StartStationID == EndStationID) {
        return;
    }

    let aJourneys = [];

    // alle Daten laden
    let qry = new DBAF_Request(API_URL + "/journeys?from=" + StartStationID + "&to=" + EndStationID + "&departure=" + StartDateTime.toISOString() + "&transfers=1000&results=1&suburban=false&bus=false&ferry=false&subway=false&tram=false&taxi=false", true, (StatusCode, Data) => {
        let aJourney = Data.journeys[0];

        let i = 0;
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

                let dLastStopArrival = new Date(aLastStop.arrival);
                let dCurrentStopDeparture = new Date(aStop.departure);

                iWaitingMins = (dCurrentStopDeparture.getTime() - dLastStopArrival.getTime()) / 1000 / 60;
                iTotalWaitingMins+= iWaitingMins;
            }

            // Daten zum Result hinzufügen
            aJourneys.push({
                "ID": "" + i,
                "startStation": aStop.origin.name,
                "endStation": aStop.destination.name,
                "timeStart": dStartDate,
                "timeEnd": dEndDate,
                "line": sLineName,
                "timeWaiting": ConvertMinutesToStr(iWaitingMins, false),
                "timeTrip": ConvertMinutesToStr(iTripMins, false)
            });
            i++;
        }  

        // OnSuccess aufrufen
        if (OnSuccess != null) {
            OnSuccess(iTotalWaitingMins, iTotalTripMins, dPrice);
        }
    });

    return aJourneys;
}