<div id="map-container">
    <canvas id="map-canvas"></canvas>
</div>

<script>
    window.MAP_CONFIG = {
        mapId: %1$d,
        isMj: false,
        image: '%2$s',

        grid: {
            columns: %3$d,
            rows: %4$d,
            cellSize: %5$d,
            tokenScale: 0.95
        },

        tokens: %6$s,
        visibleCells: %7$s,
        discoveredCells: %8$s,
    };
</script>