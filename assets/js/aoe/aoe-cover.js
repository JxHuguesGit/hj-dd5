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
