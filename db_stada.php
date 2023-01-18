<?php
    require_once 'db_base.php';

    /**
     * Filter-Klasse, um Stationen während einer Abfrage zu filtern
     */
    class StationFilter {
        public $offset = null, $limit = null, $eva = null, $searchstring = null, $category = null, $federalstate = null, $ril = null, $logicaloperator = null;
    }

    /**
     * Filter-Klasse, um SZentralen während einer Abfrage zu filtern
     */
    class SZentralenFilter {
        public $offset = null, $limit = null;
    }

    /**
     * Klasse, um Anfragen an die Station-Data zu stellen.
     * JSON-Ergebnis bzw. Fehler-Nachricht einer Anfrage können über "GetJSONResult" und "GetErrorMessage" ausgelesen werden.
     */
    class DBAPI_StaDa extends DBAPI_Base {
        /**
         * Erreichbarkeit der Station-Data-API abfragen
         * @return Boolean Erreichbarkeit der API
         */
        public static function StaDaIsAvailable() {
            // Unauthorized wird geprüft (keine API-ID), ansonsten ist die Seite nicht verfügbar
            return DBAPI_Base::GetHTTPCode('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations') == 401;
        }

        /**
         * Alle Stationen gefiltert abholen
         * @param StationFilter $filter Filterung der Daten
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

        /**
         * Alle Daten zu einer Station abholen
         * @param Integer $ID ID der Station - muss von GetStations abgeholt werden (Bsp: 2)
         */
        public function GetStation(int $ID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/' . $ID);
        }

        /**
         * Alle SZentralen gefiltert abholen
         * @param SZentralenFilter $filter Filterung der Daten
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

        /**
         * Alle Daten zu einer SZentrale abholen
         * @param Integer $ID ID der Station - muss von GetSZentralen abgeholt werden (Bsp: 27)
         */
        public function GetSZentrale(int $ID) {
            $this->GetData('https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/szentralen/' . $ID);
        }
    }
?>