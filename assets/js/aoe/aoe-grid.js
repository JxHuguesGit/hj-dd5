import { GRID_MIN } from "./aoe-config.js";
import { GRID_MAX } from "./aoe-config.js";
import { setSelectedDistance } from "./aoe-config.js";

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
