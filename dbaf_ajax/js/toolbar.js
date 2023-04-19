/*
    toolbar.js
    ----------
    Stellt die Navigationsleiste auf jeder Seite ein.
*/

// Navigationsleiste einrichten
$('#toolbar').dxToolbar({
    items: [{
        location: 'before',
        icon: 'menu',
        template() {
            // Home-Seite
            return $("<div class='dbaf-toolbar-label-main'><a href='index.html'>D.B.A.F.</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            // Stationsdaten
            return $("<div class='toolbar-label'><a href='stationdata.html'>Stationsdaten</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            // Fahrplanauskunft
            return $("<div class='toolbar-label'><a href='timetable.html'>Fahrplanauskunft</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            // Routenplaner
            return $("<div class='toolbar-label'><a href='routeplanning.html'>Routenplaner</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            // Karte
            return $("<div class='toolbar-label'><a href='map.html'>Karte</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            // Über uns
            return $("<div class='toolbar-label'><a href='about.html'>Über uns</a></div>");
        }
    }],
});