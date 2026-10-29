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

    const cx = (GRID_MAX_X - GRID_MIN_X + 1) / 2;
    const cy = (GRID_MAX_Y - GRID_MIN_Y + 1) / 2;

    $svg.append(`
        <circle
            cx="${cx}"
            cy="${cy}"
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
