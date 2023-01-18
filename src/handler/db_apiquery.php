<?php
    require_once 'db_base.php';

    /*
        Klasse, um Filter-Attribute für Stationen zu festzulegen
    */
    class StationFilter {
        public $offset = null, $limit = null, $eva = null, $searchstring = null, $category = null, $federalstate = null, $ril = null, $logicaloperator = null;
    }

    /*
        Klasse, um Filter-Attribute für S-Zentralen zu festzulegen
    */
    class SZentralenFilter {
        public $offset = null, $limit = null;
    }

    /*
        Klasse, um Anfragen an den Fahrplan zu stellen.
        Funktionen werden ausgeführt und können dann aus JSONResult bzw. errorMessage (sofern Fehler aufgetreten sind) ausgelesen werden.
    */
    class DBAPI_Fahrplan extends DBAPI_Base {
        /*
            Erreichbarkeit von Fahrplan abfragen
        */
        public static function FahrplanIsAvailable() {
            // Unauthorized wird geprüft (keine API-ID), ansonsten ist die Seite nicht verfügbar
            return DBAPI_Base::GetHTTPCode('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/arrivalBoard') == 401;
        }
        
        /*
            Arrival-Board zurückgeben
            $locID muss von Locations abgeholt werden (Bsp: 8011201)
            $date: Date-Format yyyy-mm-dd/hh:mm:ss (Bsp: 2023-01-11)
        */
        public function GetArrivalBoard(int $locID, String $date) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/arrivalBoard/' . $locID . '?date=' . $date);
        }

        /*
            Departure-Board zurückgeben
            $locID muss von Locations abgeholt werden (Bsp: 8011201)
            $date: Date-Format yyyy-mm-dd/hh:mm:ss (Bsp: 2023-01-11)
        */
        public function GetDepartureBoard(int $locID, String $date) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/departureBoard/' . $locID . '?date=' . $date);
        }

        /*
            Alle Journeys zurückgeben
            $detailsID muss vom arrivalBoard oder departureBoard abgeholt werden (Bsp: 94023~33323~779436~358377~80_2023-01-11)
        */
        public function GetJourneyDetails(String $detailsID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/journeyDetails/' . $detailsID);
        }

        /*
            Alle Locations zurückgeben
            $name: zu suchender Name; Ergebnisse werden nach Ähnlichkeit des Namens gesucht
        */
        public function GetLocations(String $name) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/location/' . $name);
        }
    }

    /*
        Klasse, um Anfragen an StaDa (StationData) zu stellen.
    */
    class DBAPI_StaDa extends DBAPI_Base {
        /*
            Erreichbarkeit von StationData abfragen
        */
        public static function StaDaIsAvailable() {
            // Unauthorized wird geprüft (keine API-ID), ansonsten ist die Seite nicht verfügbar
            return DBAPI_Base::GetHTTPCode('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations') == 401;
        }

        /*
            Alle Stationen abrufen
            $filter, um Daten zu filtern (Standard: new StationFilter)
        */
        public function GetStations(StationFilter $filter) {
            $URL = 'https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations?';
            
            if ($filter->offset != null) {
                $URL .= 'offset=' . $filter->offset . '&';
            }
            if ($filter->limit != null) {
                $URL .= 'limit=' . $filter->limit . '&';
            }
            if ($filter->searchstring != null) {
                $URL .= 'searchstring=' . $filter->searchstring . '&';
            }
            if ($filter->category != null) {
                $URL .= 'category=' . $filter->category . '&';
            }
            if ($filter->federalstate != null) {
                $URL .= 'federalstate=' . $filter->federalstate . '&';
            }
            if ($filter->eva != null) {
                $URL .= 'eva=' . $filter->eva . '&';
            }
            if ($filter->ril != null) {
                $URL .= 'ril=' . $filter->ril . '&';
            }
            if ($filter->logicaloperator != null) {
                $URL .= 'logicaloperator=' . $filter->logicaloperator;
            }

            $this->GetData($URL);
        }

        /*
            Gibt alle Daten zu einer Station zurück
            $ID muss von GetStations abgeholt werden (Attributname "number", Bsp: 2)
        */
        public function GetStation(int $ID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/' . $ID);
        }

        /*
            Alle S-Zentralen abrufen
            $filter, um Daten zu filtern (Standard: new SZentralenFilter)
        */
        public function GetSZentralen(SZentralenFilter $filter) {
            $URL = 'https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/szentralen?';
            if ($filter->offset != null) {
                $URL .= 'offset=' . $filter->offset . '&';
            }
            if ($filter->limit != null) {
                $URL .= 'limit=' . $filter->limit . '&';
            }

            $this->GetData($URL);
        }

        /*
            Gibt alle Daten zu einer S-Zentrale zurück
            $ID muss von GetSZentralen abgeholt werden (Attributname "number", Bsp: 27)
        */
        public function GetSZentrale(int $ID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/szentralen/' . $ID);
        }
    }
?>