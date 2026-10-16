import { CELL_METERS } from "./aoe-config.js";
import { getCellCoordinates, getCurrentPosition } from "./aoe-grid.js";
import { drawAoeResult } from "./aoe-svg.js";
import { isRayBlocked, getObstacles } from "./aoe-cover.js";
import { getCellCoverage, getCellVertices, isPointInsideTriangle, isPointInsideLine } from "./aoe-geometry.js";

export function updateAoe() {
    $("#grid .cell").removeClass(
        "aoe " +
        "aoe-cover-none " +
        "aoe-cover-half " +
        "aoe-cover-three-quarters " +
        "aoe-cover-total"
    );
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
    updateLineCover();
}

function isCellCoveredByCone(
    cellX,
    cellY,
    leftX,
    leftY,
    rightX,
    rightY
) {
    const triangle = {
        a: { x: 0, y: 0 },
        b: { x: leftX, y: leftY },
        c: { x: rightX, y: rightY }
    };

    return getCellCoverage(
        cellX,
        cellY,
        (px, py) =>
            isPointInsideTriangle(
                { x: px, y: py },
                triangle
            )
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

function calculateAoeCover(
    sourceX,
    sourceY,
    targetX,
    targetY,
    obstacles
) {
    const sourceVertices =
        getCellVertices(sourceX, sourceY);

    const targetVertices =
        getCellVertices(targetX, targetY);

    let minVisible = 4;

    sourceVertices.forEach(function (source) {

        let visible = 0;

        targetVertices.forEach(function (target) {

            if (
                !isRayBlocked(
                    source,
                    target,
                    obstacles
                )
            ) {
                visible++;
            }

        });

        minVisible = Math.min(
            minVisible,
            visible
        );
    });

    switch (minVisible) {

        case 0:
            return 100;

        case 1:
            return 75;

        case 2:
            return 50;

        default:
            return 0;
    }
}

function updateLineCover() {

    const obstacles = getObstacles();

    $("#grid .cell.aoe").each(function () {

        const $cell = $(this);

        const {
            cellX,
            cellY
        } = getCellCoordinates($cell);

        const cover = calculateAoeCover(
            0,
            0,
            cellX,
            cellY,
            obstacles
        );

        $cell.removeClass(
            "aoe-cover-none " +
            "aoe-cover-half " +
            "aoe-cover-three-quarters " +
            "aoe-cover-total"
        );
        switch (cover) {
            case 100:
                $cell.addClass("aoe-cover-total");
                break;

            case 75:
                $cell.addClass("aoe-cover-three-quarters");
                break;

            case 50:
                $cell.addClass("aoe-cover-half");
                break;

            default:
                $cell.addClass("aoe-cover-none");
        }
        $cell.attr(
            "data-cover",
            cover
        );
    });
}
