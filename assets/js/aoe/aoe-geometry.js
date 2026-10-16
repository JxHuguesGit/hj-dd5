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

export function doesSegmentOverlapEdge(
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

export function isPointInsideTriangle(
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
