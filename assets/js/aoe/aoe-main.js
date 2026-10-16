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
});
