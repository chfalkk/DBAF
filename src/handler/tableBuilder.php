<?php
    /**
     * Klasse, um Tabellen in HTML-Format aus JSON-Daten (beliebige Arrays) zu erstellen
     */
    class TableBuilder {
        /**
         * Tabelle aufbauen und zurückgeben
         * @param String $title Tabellen-Titel
         * @param Array $data JSON-Daten als Array
         * @return String HTML-Tabelle
         */
        public static function BuildTable(String $title, array $data) {
            $html =
                '<div class="db_table">
                    <h2>' . $title . '</h2>
                    <div class="db_table_scroll">
                        <table>';
            
            if ($data == null || count($data) < 1) {
                $html .= '<p>Es können keine Daten angezeigt werden!</p>';
            } else {
                // 1D/2D-Tabelle aufbauen
                $html .= TableBuilder::Is2DTable($data) ? TableBuilder::Build2DTable($data) : TableBuilder::Build1DTable($data);
            }
    
            $html .= '</div></div>';
            return $html;
        }

        /**
         * Eintrag zu HTML formattieren und zurückgeben
         * @param mixed $entry auszugebende Daten
         * @return String Datensatz im HTML-Format
         */
        private static function EchoEntry($entry) {
            $html = '<td>';
            if (is_array($entry)) {
                // Abhängig, ob Eintrag ein 2D-Array -> 2D oder 1D-Tabelle erstellen
                $html .= TableBuilder::Is2DTable($entry) ? TableBuilder::Build2DTable($entry) : TableBuilder::Build1DTable($entry);
            } else {
                // Eintrag ausgeben
                $html .= $entry;
            }
            $html .= '</td>';

            return $html;
        }

        /**
         * prüfen, ob Datensatz ein 2D-Array ist
         * @param Array $data Datensatz
         * @return Boolean True, wenn Datensatz ein 2D-Array (Tabelle) ist
         */
        private static function Is2DTable(array $data) {
            foreach ($data as $entry) {
                if (!is_array($entry)) {
                    // wenn Eintrag kein Array, dann abbrechen ($data ist kein 2D-Array)
                    return false;
                }
            }
            return true;
        }

        /**
         * Einzeilige Tabelle erstellen
         * @param Array $data JSON-Daten
         * @return String Tabelle mit Datensatz im HTML-Format
         */
        private static function Build1DTable(array $data) {
            $html = '<table>';
    
            // Header
            $html .= '<tr>';
            foreach ($data as $name => $value) {
                $html .= '<th>' . strtoupper($name) . '</th>';
            }
            $html .= '</tr>';
    
            // Body
            $html .= '<tr>';
            foreach ($data as $entry) {
                $html .= TableBuilder::EchoEntry($entry);
            }
            $html .= '</tr>';
    
            $html .= '</table>';
            return $html;
        }

        /**
         * 2D-Tabelle aus Datensätzen aufbauen
         * @param Array $data alle Datensätze
         * @return String Tabelle mit allen Datensätzen im HTML-Format
         */
        private static function Build2DTable(array $data) {
            $html = '<table>';
    
            // Header
            $html .= '<tr>';
            $header = [];
            // für jede Zeile
            foreach ($data as $row) {
                // für jede Spalte
                foreach ($row as $name => $value) {
                    // wenn name noch nicht in Table-Header vorhanden
                    if (!in_array($name, $header)) {
                        // zu Headern hinzufügen und ausgeben
                        array_push($header, $name);
                        $html .= '<th>' . strtoupper($name) . '</th>';
                    }
                }
            }
            $html .= '</tr>';
    
            // Body
            foreach ($data as $row) {
                $html .= '<tr>';
                
                // Für jeden Eintrag (Zeile)
                foreach ($header as $attribute) {
                    // Attribut im Eintrag suchen
                    if (!isset($row[$attribute])) {
                        $html .= '<td> </td>';
                        continue;
                    }
    
                    // Daten ausgeben
                    $value = $row[$attribute];
                    $html .= TableBuilder::EchoEntry($value);
                }
    
                $html .= '</tr>';
            }
            $html .= '</table>';
            
            return $html;
        }

    }