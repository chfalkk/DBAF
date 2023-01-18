<?php
    require_once 'db_base.php';
    
    /**
     * Klasse, um Anfragen an den Fahrplan zu stellen.
     * JSON-Ergebnis bzw. Fehler-Nachricht einer Anfrage können über "GetJSONResult" und "GetErrorMessage" ausgelesen werden.
     */
    class DBAPI_Fahrplan extends DBAPI_Base {
        /**
         * Erreichbarkeit der Fahrplan-API abfragen
         * @return Boolean Erreichbarkeit der API
         */
        public static function FahrplanIsAvailable() {
            // Unauthorized wird geprüft (keine API-ID), ansonsten ist die Seite nicht verfügbar
            return DBAPI_Base::GetHTTPCode('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/arrivalBoard') == 401;
        }
        
        /**
         * Arrival-Board abholen
         * @param Integer $locID ID des Standortes - muss von Locations abgeholt werden (Bsp: 8011201)
         * @param Date $date Datum des Fahrplans (Format: "yyyy-mm-dd" (Bsp: 2023-01-11)
         */
        public function GetArrivalBoard(int $locID, String $date) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/arrivalBoard/' . $locID . '?date=' . $date);
        }

        /**
         * Departure-Board abholen
         * @param Integer $locID ID des Standortes - muss von Locations abgeholt werden (Bsp: 8011201)
         * @param Date $date Datum des Fahrplans (Format: "yyyy-mm-dd" (Bsp: 2023-01-11)
         */
        public function GetDepartureBoard(int $locID, String $date) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/departureBoard/' . $locID . '?date=' . $date);
        }

        /**
         * Alle Journeys abholen
         * @param String $detailsID ID der Zugfahrt - muss von arrivalBoard oder departureBoard abgeholt werden (Bsp: 94023\~33323\~779436\~358377\~80_2023-01-11)
         */
        public function GetJourneyDetails(String $detailsID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/journeyDetails/' . $detailsID);
        }

        /**
         * Alle Locations abholen
         * @param String $name Abfragename - Ergebnisse werden nach Ähnlichkeit des Namens gesucht (* für alle Locations)
         */
        public function GetLocations(String $name) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/fahrplan/v1/location/' . $name);
        }
    }