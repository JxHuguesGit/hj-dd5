import { getDistanceMeters } from "./aoe-distance.js";

export function displayDistance(x, y) {
    const distance = getDistanceMeters(x, y);
    const formattedDistance =
        distance.toLocaleString("fr-FR");
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
