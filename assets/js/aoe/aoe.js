// aoe-aoe.js
import { CELL_METERS, GRID_MAX_X, GRID_MAX_Y, GRID_MIN_X, GRID_MIN_Y } from "./aoe-config.js";
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


// aoe-config.js
export const GRID_SIZE = 49;
export const GRID_MIN = -(GRID_SIZE - 1) / 2;
export const GRID_MAX = (GRID_SIZE - 1) / 2;

export const CELL_METERS = 1.5;
export const AOE_SAMPLES = 10;
export const EPSILON = 1e-9;

export const COVER_BY_BLOCKED_RAYS = {
    0: 0,
    1: 0,
    2: 50,
    3: 75,
    4: 100
};

export const BOARD_MOVEMENTS = {
    Numpad7: { dx:  1, dy:  1 },
    Numpad8: { dx:  0, dy:  1 },
    Numpad9: { dx: -1, dy:  1 },

    Numpad4: { dx:  1, dy:  0 },
    Numpad6: { dx: -1, dy:  0 },

    Numpad1: { dx:  1, dy: -1 },
    Numpad2: { dx:  0, dy: -1 },
    Numpad3: { dx: -1, dy: -1 }
};

let selectedDistance = null;

export function getSelectedDistance() {
    return selectedDistance;
}

export function setSelectedDistance(value) {
    selectedDistance = value;
}


// aoe-cover.js
import { COVER_BY_BLOCKED_RAYS } from "./aoe-config.js";
import { clearCoverResult, drawCoverResult } from "./aoe-svg.js";
import { getCellCoordinates, getCurrentPosition, getCell } from "./aoe-grid.js";
import { getCellVertices, doesSegmentCrossCell, doesSegmentOverlapEdge } from "./aoe-geometry.js";
import { displayCoverResult } from "./aoe-ui.js";

export function updateCover() {
    if ($("#mode").val() !== "cover") {
        return;
    }
    const { x, y } = getCurrentPosition();
    const size = Number.parseInt(
        $("#creature-size").val(),
        10
    );
    if (
        Number.isNaN(x) ||
        Number.isNaN(y) ||
        Number.isNaN(size)
    ) {
        return;
    }
    drawCoverTarget(x, y, size);
    if (isTargetAdjacentToSource(x, y, size)) {
        clearCoverResult();
        displayCoverResult(null);
        return null;
    }
    const result = calculateCover(
        x,
        y,
        size
    );
    drawCoverResult(result);
    displayCoverResult(result);
    return result;
}

function drawCoverTarget(originX, originY, size) {
    $("#grid .cell").removeClass("target");
    for (let x = originX; x < originX + size; x++) {
        for (let y = originY; y < originY + size; y++) {
            getCell(x, y).addClass("target");
        }
    }
}

function getSourceVertices() {
    return getCellVertices(0, 0);
}

function getTargetGeometry(originX, originY, size) {
    const vertices = [];
    const cells = [];
    for (let vy = 0; vy <= size; vy++) {
        for (let vx = 0; vx <= size; vx++) {
            vertices.push({
                x: originX - 0.5 + vx,
                y: originY - 0.5 + vy
            });
        }
    }

    function vertexIndex(vx, vy) {
        return vy * (size + 1) + vx;
    }

    for (let cy = 0; cy < size; cy++) {
        for (let cx = 0; cx < size; cx++) {
            cells.push({
                x: originX + cx,
                y: originY + cy,
                vertices: [
                    vertexIndex(cx,     cy),
                    vertexIndex(cx + 1, cy),
                    vertexIndex(cx + 1, cy + 1),
                    vertexIndex(cx,     cy + 1)
                ]
            });
        }
    }

    return {
        vertices,
        cells
    };
}

export function getObstacles() {
    const obstacles = [];
    $("#grid .cell.obstacle")
        .not(".target")
        .each(function () {
            const $cell = $(this);
            const {
                cellX,
                cellY
            } = getCellCoordinates($cell);
            obstacles.push({
                x: cellX,
                y: cellY
            });
        });
    return obstacles;
}

export function isRayBlocked(source, target, obstacles) {
    for (const obstacle of obstacles) {
        if (
            doesSegmentCrossCell(
                source.x,
                source.y,
                target.x,
                target.y,
                obstacle.x,
                obstacle.y
            )
        ) {
            return true;
        }
    }
    return doesRayFollowSharedObstacleEdge(
        source,
        target,
        obstacles
    );
}

function calculateVertexVisibility(
    source,
    targetVertices,
    obstacles
) {
    return targetVertices.map(function (vertex) {
        return {
            vertex: vertex,
            blocked: isRayBlocked(
                source,
                vertex,
                obstacles
            )
        };
    });
}

function calculateCellCover(cell, visibility) {
    const rays = cell.vertices.map(function (vertexIndex) {
        const result = visibility[vertexIndex];
        return {
            vertex: result.vertex,
            blocked: result.blocked
        };
    });
    const blocked = rays.filter(function (ray) {
        return ray.blocked;
    }).length;
    return {
        cover: COVER_BY_BLOCKED_RAYS[blocked],
        blocked,
        rays
    };
}

function calculateCover(
    targetX,
    targetY,
    targetSize
) {
    const sourceVertices = getSourceVertices();
    const target = getTargetGeometry(
        targetX,
        targetY,
        targetSize
    );
    const obstacles = getObstacles();
    let bestResult = null;
    sourceVertices.forEach(function (source) {
        const visibility =
            calculateVertexVisibility(
                source,
                target.vertices,
                obstacles
            );
        target.cells.forEach(function (cell) {
            const result =
                calculateCellCover(
                    cell,
                    visibility
                );
            const candidate = {
                cover: result.cover,
                blocked: result.blocked,
                source: source,
                targetCell: {
                    x: cell.x,
                    y: cell.y
                },
                rays: result.rays
            };
            if (
                bestResult === null ||
                candidate.cover < bestResult.cover
            ) {
                bestResult = candidate;
            }
        });
    });
    return bestResult;
}

function distanceToRange(min, max) {
    if (min>0) {
        return min;
    }
    if (max<0) {
        return -max;
    }
    return 0;
}

function isTargetAdjacentToSource(x, y, size) {
    const minX = x;
    const maxX = x + size - 1;
    const minY = y;
    const maxY = y + size - 1;
    const distanceX = distanceToRange(minX, maxX);
    const distanceY = distanceToRange(minY, maxY);
    return distanceX <= 1 && distanceY <= 1;
}

function doesRayFollowSharedObstacleEdge(
    source,
    target,
    obstacles
) {
    const obstacleSet = new Set(
        obstacles.map(function (obstacle) {
            return `${obstacle.x},${obstacle.y}`;
        })
    );

    for (const obstacle of obstacles) {
        if (
            obstacleSet.has(
                `${obstacle.x + 1},${obstacle.y}`
            )
        ) {
            const edgeX = obstacle.x + 0.5;
            if (
                doesSegmentOverlapEdge(
                    {start: source, end: target},
                    {start: {x: edgeX, y: obstacle.y - 0.5}, end: {x: edgeX,y: obstacle.y + 0.5}}
                )
            ) {
                return true;
            }
        }

        if (
            obstacleSet.has(
                `${obstacle.x},${obstacle.y + 1}`
            )
        ) {
            const edgeY = obstacle.y + 0.5;
            if (
                doesSegmentOverlapEdge(
                    {start: source, end: target},
                    {start: {x: obstacle.x - 0.5, y: edgeY}, end: {x: obstacle.x + 0.5, y: edgeY}}
                )
            ) {
                return true;
            }
        }
    }
    return false;
}


// aoe-distance.js
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


// aoe-geometry.js
import { AOE_SAMPLES, EPSILON } from "./aoe-config.js";

export function doesSegmentCrossCell(
    x1,
    y1,
    x2,
    y2,
    cellX,
    cellY
) {
    const minX = cellX - 0.5 + EPSILON;
    const maxX = cellX + 0.5 - EPSILON;
    const minY = cellY - 0.5 + EPSILON;
    const maxY = cellY + 0.5 - EPSILON;
    const dx = x2 - x1;
    const dy = y2 - y1;
    let tMin = 0;
    let tMax = 1;
    function clip(p, q) {
        if (Math.abs(p) < EPSILON) {
            return q >= 0;
        }
        const r = q / p;
        if (p < 0) {
            if (r > tMax) {
                return false;
            }
            if (r > tMin) {
                tMin = r;
            }
        } else {
            if (r < tMin) {
                return false;
            }
            if (r < tMax) {
                tMax = r;
            }
        }
        return true;
    }
    if (!clip(-dx, x1 - minX)) {
        return false;
    }
    if (!clip(dx, maxX - x1)) {
        return false;
    }
    if (!clip(-dy, y1 - minY)) {
        return false;
    }
    if (!clip(dy, maxY - y1)) {
        return false;
    }
    return tMax - tMin > EPSILON;
}

export function doesSegmentOverlapEdge(segment, edge) {
    const { start, end } = segment;
    const { start: edgeStart, end: edgeEnd } = edge;

    if (Math.abs(edgeStart.x - edgeEnd.x) < EPSILON) {
        if (
            Math.abs(start.x - end.x) >= EPSILON ||
            Math.abs(start.x - edgeStart.x) >= EPSILON
        ) {
            return false;
        }

        const segmentMin = Math.min(start.y, end.y);
        const segmentMax = Math.max(start.y, end.y);
        const edgeMin = Math.min(edgeStart.y, edgeEnd.y);
        const edgeMax = Math.max(edgeStart.y, edgeEnd.y);

        return (
            Math.min(segmentMax, edgeMax) -
            Math.max(segmentMin, edgeMin)
        ) > EPSILON;
    }

    if (Math.abs(edgeStart.y - edgeEnd.y) < EPSILON) {
        if (
            Math.abs(start.y - end.y) >= EPSILON ||
            Math.abs(start.y - edgeStart.y) >= EPSILON
        ) {
            return false;
        }

        const segmentMin = Math.min(start.x, end.x);
        const segmentMax = Math.max(start.x, end.x);
        const edgeMin = Math.min(edgeStart.x, edgeEnd.x);
        const edgeMax = Math.max(edgeStart.x, edgeEnd.x);

        return (
            Math.min(segmentMax, edgeMax) -
            Math.max(segmentMin, edgeMin)
        ) > EPSILON;
    }

    return false;
}

export function getCellCoverage(cellX, cellY, predicate) {
    let covered = 0;
    for (let sy = 0; sy < AOE_SAMPLES; sy++) {
        for (let sx = 0; sx < AOE_SAMPLES; sx++) {
            const px =
                cellX - 0.5 +
                (sx + 0.5) / AOE_SAMPLES;
            const py =
                cellY - 0.5 +
                (sy + 0.5) / AOE_SAMPLES;
            if (predicate(px, py)) {
                covered++;
            }
        }
    }
    return covered /
        (AOE_SAMPLES * AOE_SAMPLES);
}

export function getCellVertices(x, y) {
    return [
        { x: x - 0.5, y: y - 0.5 },
        { x: x + 0.5, y: y - 0.5 },
        { x: x + 0.5, y: y + 0.5 },
        { x: x - 0.5, y: y + 0.5 }
    ];
}

export function isPointInsideLine(
    px,
    py,
    targetX,
    targetY,
    width
) {
    const lengthSquared =
        targetX * targetX +
        targetY * targetY;
    if (lengthSquared === 0) {
        return false;
    }
    const t =
        (px * targetX + py * targetY) /
        lengthSquared;
    if (t < 0 || t > 1) {
        return false;
    }
    const projectedX = t * targetX;
    const projectedY = t * targetY;
    const dx = px - projectedX;
    const dy = py - projectedY;
    const distanceSquared =
        dx * dx +
        dy * dy;
    const halfWidth = width / 2;
    return distanceSquared <=
        halfWidth * halfWidth;
}

export function isPointInsideTriangle(point, triangle) {
    const { a, b, c } = triangle;

    const d1 = triangleSign(point, a, b);
    const d2 = triangleSign(point, b, c);
    const d3 = triangleSign(point, c, a);

    const hasNegative =
        d1 < 0 ||
        d2 < 0 ||
        d3 < 0;

    const hasPositive =
        d1 > 0 ||
        d2 > 0 ||
        d3 > 0;

    return !(hasNegative && hasPositive);
}


function triangleSign(p1, p2, p3) {
    return (
        (p1.x - p3.x) * (p2.y - p3.y) -
        (p2.x - p3.x) * (p1.y - p3.y)
    );
}



// aoe-grid.js
import { GRID_MIN, GRID_MAX, setSelectedDistance } from "./aoe-config.js";
import { updateAoe } from "./aoe-aoe.js";
import { updateCover } from "./aoe-cover.js";
import { displayDistance } from "./aoe-ui.js";


export function getCellCoordinates($cell) {
    return {
        cellX: Number.parseInt($cell.data("x"), 10),
        cellY: Number.parseInt($cell.data("y"), 10)
    };
}

export function getCurrentPosition() {
    return {
        x: Number.parseInt($("#x").val(), 10),
        y: Number.parseInt($("#y").val(), 10)
    };
}

export function setCurrentPosition(x, y) {
    $("#x").val(x);
    $("#y").val(y);
}

export function translateBoard(dx, dy) {
    const mode = $("#mode").val();
    if (
        mode !== "cover" &&
        mode !== "aoe"
    ) {
        return;
    }
    translateObstacles(dx, dy);
    if (mode === "cover") {
        const {
            x: targetX,
            y: targetY
        } = getCurrentPosition();
        if (
            !Number.isNaN(targetX) &&
            !Number.isNaN(targetY)
        ) {
            setCurrentPosition(
                targetX + dx,
                targetY + dy
            );
        }
        updateCover();
        const {
            x: newX,
            y: newY
        } = getCurrentPosition();
        setSelectedDistance({
            x: newX,
            y: newY
        });
        displayDistance(
            newX,
            newY
        );
        return;
    }
    if (mode === "aoe") {
        updateAoe();
    }
}

export function getCell(x, y) {
    return $(
        `.cell[data-x="${x}"][data-y="${y}"]`
    );
}

function translateObstacles(dx, dy) {
    const obstacles = [];
    $("#grid .cell.obstacle").each(function () {
        const {
            cellX,
            cellY
        } = getCellCoordinates($(this));
        obstacles.push({
            x: cellX + dx,
            y: cellY + dy
        });
    });
    $("#grid .cell").removeClass("obstacle");
    obstacles.forEach(function (obstacle) {
        if (
            obstacle.x < GRID_MIN_X ||
            obstacle.x > GRID_MAX_X ||
            obstacle.y < GRID_MIN_Y ||
            obstacle.y > GRID_MAX_Y
        ) {
            return;
        }
        getCell(
            obstacle.x,
            obstacle.y
        ).addClass("obstacle");
    });
}


// aoe-main.js
import { CELL_METERS, BOARD_MOVEMENTS, getSelectedDistance, setSelectedDistance } from "./aoe-config.js";
import { updateGridSize, clearCoverResult } from "./aoe-svg.js";
import { updateInterface, displayDistance } from "./aoe-ui.js";
import { colorDistanceGrid } from "./aoe-distance.js";
import { updateAoe } from "./aoe-aoe.js";
import { updateCover } from "./aoe-cover.js";
import { getCellCoordinates, setCurrentPosition, translateBoard } from "./aoe-grid.js";

$(function () {
    updateGridSize();
    updateInterface();
    colorDistanceGrid();

    const initialMode = $("#mode").val();
    if (initialMode === "aoe") {
        updateAoe();
    } else if (initialMode === "cover") {
        updateCover();
    }

    $("#mode").on("change", function () {
        updateInterface();
        const mode = $(this).val();
        if (mode === "aoe") {
            $("#grid .cell").removeClass("target");
            clearCoverResult();
            updateAoe();
        } else if (mode === "cover") {
            $("#grid .cell").removeClass("aoe");
            updateCover();
        } else {
            $("#grid .cell").removeClass("aoe target");
            clearCoverResult();
        }
    });

    $("#shape").on("change", function () {
        updateInterface();
        if ($("#mode").val() === "aoe") {
            updateAoe();
        }
    });

    $("#size").on(
        "change input",
        function () {
            if ($("#mode").val() === "aoe") {
                updateAoe();
            }
        }
    );

    $("#x, #y").on("change input", function () {
        const mode = $("#mode").val();
        if (mode === "aoe") {
            updateAoe();
        }
        if (mode === "cover") {
            updateCover();
        }
    });

    $("#grid")
        .on("click", ".cell", function (event) {
            const $cell = $(this);
            const mode = $("#mode").val();
            const { cellX, cellY } = getCellCoordinates($cell);
            setSelectedDistance({
                x: cellX,
                y: cellY
            });
            displayDistance(cellX, cellY);
            if (
                (mode === "cover" || mode === "aoe") &&
                event.shiftKey
            ) {
                if (cellX === 0 && cellY === 0) {
                    return;
                }
                $cell.toggleClass("obstacle");
                if (mode === "cover") {
                    updateCover();
                }
                return;
            }

            if (mode === "aoe") {
                if (
                    $("#x").prop("disabled") ||
                    $("#y").prop("disabled")
                ) {
                    return;
                }
                setCurrentPosition(cellX, cellY);
                updateAoe();
                return;
            }

            if (mode === "cover") {
                setCurrentPosition(cellX, cellY);
                updateCover();
            }
        })
        .on("wheel", function (event) {
            if (
                $("#mode").val() !== "aoe" ||
                $("#size").prop("disabled")
            ) {
                return;
            }
            event.preventDefault();
            const $size = $("#size");
            const currentSize =
                Number.parseFloat($size.val()) || CELL_METERS;
            let steps =
                Math.round(currentSize / CELL_METERS);
            if (event.originalEvent.deltaY < 0) {
                steps++;
            } else {
                steps--;
            }
            steps = Math.max(1, steps);
            $size.val(steps * CELL_METERS);
            updateAoe();
        })
        .on("mouseenter", ".cell", function () {
            const $cell = $(this);
            const {
                cellX,
                cellY
            } = getCellCoordinates($cell);
            displayDistance(cellX, cellY);
        })
        .on("mouseleave", ".cell", function () {
            let selDistance = getSelectedDistance();
            if (selDistance) {
                displayDistance(
                    selDistance.x,
                    selDistance.y
                );
            } else {
                $("#distance-info").text(
                    "Distance : 0 m"
                );
            }
        });

    $("#creature-size").on("change", function () {
        if ($("#mode").val() === "cover") {
            updateCover();
        }
    });

    $(document).on("keydown", function (event) {
        const mode = $("#mode").val();
        if (
            mode !== "cover" &&
            mode !== "aoe"
        ) {
            return;
        }
        if ($(event.target).is("input, select, textarea")) {
            return;
        }
        const movement = BOARD_MOVEMENTS[event.code];
        if (!movement) {
            return;
        }
        event.preventDefault();
        translateBoard(
            movement.dx,
            movement.dy
        );
    });

    const $helpPanel = $("#help-panel");
    $("#help-toggle").on("click", function () {
        $helpPanel.toggleClass("open");
    });
    $("#help-close").on("click", function () {
        $helpPanel.removeClass("open");
    });

});


// aoe-svg.js
import { GRID_SIZE, CELL_METERS } from "./aoe-config.js";
import { getCell } from "./aoe-grid.js";

export function clearCoverResult() {
    const svg = document.querySelector("#overlay");
    if (svg) {
        svg.replaceChildren();
    }
    $("#grid .cell").removeClass("cover-selected");
}

export function updateGridSize() {
    $("#overlay").attr(
        "viewBox",
        `0 0 ${GRID_SIZE} ${GRID_SIZE}`
    );
}

function createSvgElement(name, attributes = {}) {
    const element = document.createElementNS(
        "http://www.w3.org/2000/svg",
        name
    );
    for (const [key, value] of Object.entries(attributes)) {
        element.setAttribute(key, value);
    }
    return element;
}

export function drawCoverResult(result) {
    const svg = document.querySelector("#overlay");
    svg.replaceChildren();
    $("#grid .cell").removeClass("cover-selected");
    if (!result) {
        return;
    }
    const source = gridToSvg(result.source);
    result.rays.forEach(function (ray) {
        const target = gridToSvg(ray.vertex);
        const line = createSvgElement("line", {
            x1: source.x,
            y1: source.y,
            x2: target.x,
            y2: target.y,
            class: ray.blocked
                ? "cover-line cover-line-blocked"
                : "cover-line cover-line-clear"
        });
        svg.appendChild(line);
    });
    const sourceMarker = createSvgElement("circle", {
        cx: source.x,
        cy: source.y,
        r: 0.22,
        fill: "#facc15",
        stroke: "#000",
        "stroke-width": 0.08
    });
    svg.appendChild(sourceMarker);
    getCell(
        result.targetCell.x,
        result.targetCell.y
    ).addClass("cover-selected");
}

export function drawAoeResult() {
    console.log("DRAW AOE RESULT");
    const $svg = $("#overlay");
console.log("SVG :", $svg.length);
    $svg.empty();

    if ($("#mode").val() !== "aoe") {
        return;
    }

    $svg.append(`
        <circle
            cx="24.5"
            cy="24.5"
            r="5"
            fill="none"
            stroke="red"
            stroke-width="0.5"
        />
    `);
    console.log("SVG HTML :", $svg.html());
}

function drawAoeCircle(svg, centerX, centerY) {
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

    const center = gridToSvg({
        x: centerX,
        y: centerY
    });

    const circle = createSvgElement("circle", {
        cx: center.x,
        cy: center.y,
        r: radius,
        class: "aoe-outline"
    });

    svg.appendChild(circle);
}

function drawAoeCube(svg, originX, originY) {
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

    const topLeft = gridToSvg({
        x: originX - 0.5,
        y: originY - 0.5
    });

    const rectangle = createSvgElement("rect", {
        x: topLeft.x,
        y: topLeft.y,
        width: size,
        height: size,
        class: "aoe-outline"
    });

    svg.appendChild(rectangle);
}

function drawAoeCone(svg, targetX, targetY) {
    if (
        Number.isNaN(targetX) ||
        Number.isNaN(targetY) ||
        (targetX === 0 && targetY === 0)
    ) {
        return;
    }

    const length = Math.hypot(
        targetX,
        targetY
    );

    const perpendicularX =
        -targetY / length;

    const perpendicularY =
        targetX / length;

    const halfWidth = length / 2;

    const left = {
        x:
            targetX +
            perpendicularX * halfWidth,
        y:
            targetY +
            perpendicularY * halfWidth
    };

    const right = {
        x:
            targetX -
            perpendicularX * halfWidth,
        y:
            targetY -
            perpendicularY * halfWidth
    };

    const origin = gridToSvg({
        x: 0,
        y: 0
    });

    const leftSvg = gridToSvg(left);
    const rightSvg = gridToSvg(right);

    const polygon = createSvgElement("polygon", {
        points: [
            `${origin.x},${origin.y}`,
            `${leftSvg.x},${leftSvg.y}`,
            `${rightSvg.x},${rightSvg.y}`
        ].join(" "),
        class: "aoe-outline"
    });

    svg.appendChild(polygon);
}

function drawAoeLine(svg, targetX, targetY) {
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

    const length = Math.hypot(
        targetX,
        targetY
    );

    if (length === 0) {
        return;
    }

    const halfWidth = width / 2;

    const perpendicularX =
        -targetY / length;

    const perpendicularY =
        targetX / length;

    const origin = {
        x: 0,
        y: 0
    };

    const leftStart = {
        x: origin.x + perpendicularX * halfWidth,
        y: origin.y + perpendicularY * halfWidth
    };

    const rightStart = {
        x: origin.x - perpendicularX * halfWidth,
        y: origin.y - perpendicularY * halfWidth
    };

    const leftEnd = {
        x: targetX + perpendicularX * halfWidth,
        y: targetY + perpendicularY * halfWidth
    };

    const rightEnd = {
        x: targetX - perpendicularX * halfWidth,
        y: targetY - perpendicularY * halfWidth
    };

    const leftStartSvg = gridToSvg(leftStart);
    const rightStartSvg = gridToSvg(rightStart);
    const leftEndSvg = gridToSvg(leftEnd);
    const rightEndSvg = gridToSvg(rightEnd);

    const path = createSvgElement("path", {
        d: [
            `M ${leftStartSvg.x} ${leftStartSvg.y}`,
            `L ${leftEndSvg.x} ${leftEndSvg.y}`,

            `A ${halfWidth} ${halfWidth} 0 0 1 ` +
            `${rightEndSvg.x} ${rightEndSvg.y}`,

            `L ${rightStartSvg.x} ${rightStartSvg.y}`,

            `A ${halfWidth} ${halfWidth} 0 0 1 ` +
            `${leftStartSvg.x} ${leftStartSvg.y}`,

            "Z"
        ].join(" "),
        class: "aoe-outline"
    });

    svg.appendChild(path);
}

function gridToSvg(point) {
    const offset = (GRID_SIZE / 2);
    return {
        x: point.x + offset,
        y: point.y + offset
    };
}


// aoe-ui.js
import { getDistanceMeters } from "./aoe-distance.js";

export function displayDistance(x, y) {
    const distance = getDistanceMeters(x, y);
    let formattedDistance =
        distance.toLocaleString("fr-FR", {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        });
    if (distance < 10) {
        formattedDistance = ` ${formattedDistance}`;
    }
    $("#distance-info").text(
        `Distance : ${formattedDistance} m`
    );
}

export function updateInterface() {
    const mode = $("#mode").val();
    const shape = $("#shape").val();
    $("#shape, #x, #y, #size, #creature-size")
        .prop("disabled", true);
    if (mode === "distance") {
        // Rien d'autre à activer.
    } else if (mode === "aoe") {
        $("#shape, #x, #y, #size")
            .prop("disabled", false);
        switch (shape) {
            case "emanation":
                $("#x, #y")
                    .prop("disabled", true);
                $("#x").val(0);
                $("#y").val(0);
                break;
            case "cone":
                $("#size")
                    .prop("disabled", true);
                break;
        }
    } else if (mode === "cover") {
        $("#x, #y, #creature-size")
            .prop("disabled", false);
    }
    $("#grid").toggleClass(
        "selectable",
        mode === "aoe" || mode === "cover"
    );
    $("#cover-result").toggle(
        mode === "cover"
    );
}

export function displayCoverResult(result) {
    const $result = $("#cover-result");
    $result.removeClass(
        "cover-none " +
        "cover-half " +
        "cover-three-quarters " +
        "cover-total " +
        "cover-contact"
    );
    if (result === null) {
        $result
            .addClass("cover-contact")
            .text("Abri : contact");
        return;
    }
    switch (result.cover) {
        case 100:
            $result
                .addClass("cover-total")
                .text("Abri total : 100 %");
            break;
        case 75:
            $result
                .addClass("cover-three-quarters")
                .text("Abri important : 75 %");
            break;
        case 50:
            $result
                .addClass("cover-half")
                .text("Abri partiel : 50 %");
            break;
        default:
            $result
                .addClass("cover-none")
                .text("Aucun abri : 0 %");
    }
}


