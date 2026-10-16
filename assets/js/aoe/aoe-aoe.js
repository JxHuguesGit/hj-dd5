import { CELL_METERS } from "./aoe-config.js";
import { getCellCoordinates } from "./aoe-grid.js";
import { getCurrentPosition } from "./aoe-grid.js";
import { drawAoeResult } from "./aoe-svg.js";
import { getCellCoverage } from "./aoe-geometry.js";
import { isPointInsideTriangle } from "./aoe-geometry.js";
import { isPointInsideLine } from "./aoe-geometry.js";

export function updateAoe() {
    $("#grid .cell").removeClass("aoe");
    //clearAoeResult();
    if ($("#mode").val() !== "aoe") {
        return;
    }
    const shape = $("#shape").val();
    const { x, y } = getCurrentPosition();
    switch (shape) {
        case "line":
            drawLineAoe(x, y);
            break;
        case "sphere":
        case "column":
            drawRadiusAoe(x, y);
            break;
        case "emanation":
            drawRadiusAoe(0, 0);
            break;
        case "cone":
            drawConeAoe(x, y);
            break;
        case "cube":
            drawCubeAoe(x, y);
            break;
    }
    drawAoeResult();
}

function applyAoe(predicate) {
    $("#grid .cell").each(function () {
        const $cell = $(this);
        const { cellX, cellY } = getCellCoordinates($cell);
        if (predicate(cellX, cellY)) {
            $cell.addClass("aoe");
        }
    });
}

function drawCubeAoe(originX, originY) {
    const size = Math.round(
        Number.parseFloat($("#size").val()) /
        CELL_METERS
    );
    if (
        Number.isNaN(originX) ||
        Number.isNaN(originY) ||
        Number.isNaN(size) ||
        size <= 0
    ) {
        return;
    }
    applyAoe(function (x, y) {
        return (
            x >= originX &&
            x < originX + size &&
            y >= originY &&
            y < originY + size
        );
    });
}

function drawConeAoe(targetX, targetY) {
    if (
        Number.isNaN(targetX) ||
        Number.isNaN(targetY) ||
        (targetX === 0 && targetY === 0)
    ) {
        return;
    }
    const length = Math.hypot(targetX, targetY);
    const perpendicularX = -targetY / length;
    const perpendicularY = targetX / length;
    const halfWidth = length / 2;
    const leftX =
        targetX + perpendicularX * halfWidth;
    const leftY =
        targetY + perpendicularY * halfWidth;
    const rightX =
        targetX - perpendicularX * halfWidth;
    const rightY =
        targetY - perpendicularY * halfWidth;
    applyAoe(function (x, y) {
        return isCellCoveredByCone(
            x,
            y,
            leftX,
            leftY,
            rightX,
            rightY
        );
    });
}

function drawRadiusAoe(centerX, centerY) {
    const radius =
        Number.parseFloat($("#size").val()) /
        CELL_METERS;
    if (
        Number.isNaN(centerX) ||
        Number.isNaN(centerY) ||
        Number.isNaN(radius) ||
        radius <= 0
    ) {
        return;
    }
    applyAoe(function (x, y) {
        return Math.hypot(
            x - centerX,
            y - centerY
        ) <= radius;
    });
}

function drawLineAoe(targetX, targetY) {
    const width =
        Number.parseFloat($("#size").val()) /
        CELL_METERS;
    if (
        Number.isNaN(targetX) ||
        Number.isNaN(targetY) ||
        Number.isNaN(width) ||
        width <= 0
    ) {
        return;
    }
    applyAoe(function (x, y) {
        return isCellCoveredByLine(
            x,
            y,
            targetX,
            targetY,
            width
        );
    });
}

function isCellCoveredByCone(
    cellX,
    cellY,
    leftX,
    leftY,
    rightX,
    rightY
) {
    return getCellCoverage(
        cellX,
        cellY,
        function (px, py) {
            return isPointInsideTriangle(
                px,
                py,
                0,
                0,
                leftX,
                leftY,
                rightX,
                rightY
            );
        }
    ) >= 0.5;
}

function isCellCoveredByLine(
    cellX,
    cellY,
    targetX,
    targetY,
    width
) {
    return getCellCoverage(
        cellX,
        cellY,
        function (px, py) {
            return isPointInsideLine(
                px,
                py,
                targetX,
                targetY,
                width
            );
        }
    ) >= 0.5;
}
