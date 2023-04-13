// Navigationsleiste einrichten
$('#toolbar').dxToolbar({
    items: [{
        location: 'before',
        icon: 'menu',
        template() {
            return $("<div class='dbaf-toolbar-label-main'><a href='index.html'>D.B.A.F.</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            return $("<div class='toolbar-label'><a href='stationdata.html'>Stationsdaten</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            return $("<div class='toolbar-label'><a href='timetable.html'>Fahrplanauskunft</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            return $("<div class='toolbar-label'><a href='routeplanning.html'>Routenplaner</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            return $("<div class='toolbar-label'><a href='map.html'>Karte</a></div>");
        }
    }, {
        location: 'before',
        locateInMenu: 'never',
        template() {
            return $("<div class='toolbar-label'><a href='about.html'>Über uns</a></div>");
        }
    }],
});