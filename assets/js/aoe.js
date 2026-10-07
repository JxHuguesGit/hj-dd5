// config.js
const GRID_MIN = -24;
const GRID_MAX = 24;
const GRID_SIZE = 49;

const CELL_METERS = 1.5;
const AOE_SAMPLES = 10;
const EPSILON = 1e-9;

const COVER_BY_BLOCKED_RAYS = {
    0: 0,
    1: 0,
    2: 50,
    3: 75,
    4: 100
};

const BOARD_MOVEMENTS = {
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


// grid.js
function getCellCoordinates($cell) {
    return {
        cellX: parseInt($cell.data("x"), 10),
        cellY: parseInt($cell.data("y"), 10)
    };
}

function getCell(x, y) {
    return $(
        `.cell[data-x="${x}"][data-y="${y}"]`
    );
}

function getCurrentPosition() {
    return {
        x: parseInt($("#x").val(), 10),
        y: parseInt($("#y").val(), 10)
    };
}

function setCurrentPosition(x, y) {
    $("#x").val(x);
    $("#y").val(y);
}

function translateBoard(dx, dy) {
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
        selectedDistance = {
            x: newX,
            y: newY
        };
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
            obstacle.x < GRID_MIN ||
            obstacle.x > GRID_MAX ||
            obstacle.y < GRID_MIN ||
            obstacle.y > GRID_MAX
        ) {
            return;
        }
        getCell(
            obstacle.x,
            obstacle.y
        ).addClass("obstacle");
    });
}


// geometry.js
function getCellVertices(x, y) {
    return [
        { x: x - 0.5, y: y - 0.5 },
        { x: x + 0.5, y: y - 0.5 },
        { x: x + 0.5, y: y + 0.5 },
        { x: x - 0.5, y: y + 0.5 }
    ];
}

function triangleSign(
    px,
    py,
    ax,
    ay,
    bx,
    by
) {
    return (
        (px - bx) * (ay - by) -
        (ax - bx) * (py - by)
    );
}

function isPointInsideTriangle(
    px,
    py,
    ax,
    ay,
    bx,
    by,
    cx,
    cy
) {
    const d1 = triangleSign(
        px, py,
        ax, ay,
        bx, by
    );
    const d2 = triangleSign(
        px, py,
        bx, by,
        cx, cy
    );
    const d3 = triangleSign(
        px, py,
        cx, cy,
        ax, ay
    );
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

function doesSegmentCrossCell(
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

function isPointInsideLine(
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

function getCellCoverage(cellX, cellY, predicate) {
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

function doesSegmentOverlapEdge(
    x1,
    y1,
    x2,
    y2,
    edgeX1,
    edgeY1,
    edgeX2,
    edgeY2
) {
    if (Math.abs(edgeX1 - edgeX2) < EPSILON) {
        if (
            Math.abs(x1 - x2) >= EPSILON ||
            Math.abs(x1 - edgeX1) >= EPSILON
        ) {
            return false;
        }
        const segmentMin = Math.min(y1, y2);
        const segmentMax = Math.max(y1, y2);
        const edgeMin = Math.min(edgeY1, edgeY2);
        const edgeMax = Math.max(edgeY1, edgeY2);
        return (
            Math.min(segmentMax, edgeMax) -
            Math.max(segmentMin, edgeMin)
        ) > EPSILON;
    }

    if (Math.abs(edgeY1 - edgeY2) < EPSILON) {
        if (
            Math.abs(y1 - y2) >= EPSILON ||
            Math.abs(y1 - edgeY1) >= EPSILON
        ) {
            return false;
        }
        const segmentMin = Math.min(x1, x2);
        const segmentMax = Math.max(x1, x2);
        const edgeMin = Math.min(edgeX1, edgeX2);
        const edgeMax = Math.max(edgeX1, edgeX2);
        return (
            Math.min(segmentMax, edgeMax) -
            Math.max(segmentMin, edgeMin)
        ) > EPSILON;
    }
    return false;
}


// distance.js
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

function getDistanceMeters(x, y) {
    return getDistance(x, y) * CELL_METERS;
}

function colorDistanceGrid() {
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


// aoe.js
function updateAoe() {
    $("#grid .cell").removeClass("aoe");
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
}

function drawCubeAoe(originX, originY) {
    const size = Math.round(
        parseFloat($("#size").val()) /
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
        parseFloat($("#size").val()) /
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
        parseFloat($("#size").val()) /
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

function applyAoe(predicate) {
    $("#grid .cell").each(function () {
        const $cell = $(this);
        const { cellX, cellY } = getCellCoordinates($cell);
        if (predicate(cellX, cellY)) {
            $cell.addClass("aoe");
        }
    });
}

// cover.js
function updateCover() {
    if ($("#mode").val() !== "cover") {
        return;
    }
    const { x, y } = getCurrentPosition();
    const size = parseInt(
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

function getObstacles() {
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

function isRayBlocked(source, target, obstacles) {
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

function isTargetAdjacentToSource(x, y, size) {
    const minX = x;
    const maxX = x + size - 1;
    const minY = y;
    const maxY = y + size - 1;
    const distanceX =
        0 < minX
            ? minX
            : 0 > maxX
                ? -maxX
                : 0;
    const distanceY =
        0 < minY
            ? minY
            : 0 > maxY
                ? -maxY
                : 0;
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
                    source.x,
                    source.y,
                    target.x,
                    target.y,
                    edgeX,
                    obstacle.y - 0.5,
                    edgeX,
                    obstacle.y + 0.5
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
                    source.x,
                    source.y,
                    target.x,
                    target.y,
                    obstacle.x - 0.5,
                    edgeY,
                    obstacle.x + 0.5,
                    edgeY
                )
            ) {
                return true;
            }
        }
    }
    return false;
}


// cover-svg.js
function gridToSvg(point) {
    const offset = (GRID_SIZE / 2);
    return {
        x: point.x + offset,
        y: point.y + offset
    };
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

function drawCoverResult(result) {
    const svg = document.querySelector("#cover-overlay");
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

function clearCoverResult() {
    const svg = document.querySelector("#cover-overlay");
    if (svg) {
        svg.replaceChildren();
    }
    $("#grid .cell").removeClass("cover-selected");
}


// ui.js
function updateInterface() {
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

function displayDistance(x, y) {
    const distance = getDistanceMeters(x, y);
    const formattedDistance =
        distance.toLocaleString("fr-FR");
    $("#distance-info").text(
        `Distance : ${formattedDistance} m`
    );
}

function displayCoverResult(result) {
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


// app.js
$(function () {
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
            selectedDistance = {
                x: cellX,
                y: cellY
            };
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
                return;
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
                parseFloat($size.val()) || CELL_METERS;
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
            if (selectedDistance) {
                displayDistance(
                    selectedDistance.x,
                    selectedDistance.y
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
});

