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

