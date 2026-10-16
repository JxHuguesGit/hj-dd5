import { CELL_METERS } from "./aoe-config.js";
import { getCellCoordinates } from "./aoe-grid.js";

export function colorDistanceGrid() {
    $("#grid .cell").each(function () {
        const $cell = $(this);
        const { cellX, cellY } = getCellCoordinates($cell);
        $cell.removeClass(
            "distance-1 distance-2 distance-3 distance-4"
        );
        if (cellX === 0 && cellY === 0) {
            return;
        }
        const distance = getDistance(cellX, cellY);
        const color = ((distance - 1) % 4) + 1;
        $cell.addClass(`distance-${color}`);
    });
}

export function getDistanceMeters(x, y) {
    return getDistance(x, y) * CELL_METERS;
}

function getDistance(x, y) {
    const dx = Math.abs(x);
    const dy = Math.abs(y);
    const diagonal = Math.min(dx, dy);
    const straight = Math.max(dx, dy) - diagonal;
    const diagonalCost =
        Math.floor(diagonal / 2) * 3 +
        (diagonal % 2);
    return diagonalCost + straight;
}
