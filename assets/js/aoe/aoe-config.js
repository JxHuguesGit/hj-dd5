const $grid = $("#grid");

export const GRID_MIN_X = Number($grid.data("min-x"));
export const GRID_MAX_X = Number($grid.data("max-x"));
export const GRID_MIN_Y = Number($grid.data("min-y"));
export const GRID_MAX_Y = Number($grid.data("max-y"));

export const GRID_WIDTH = GRID_MAX_X - GRID_MIN_X + 1;
export const GRID_HEIGHT = GRID_MAX_Y - GRID_MIN_Y + 1;

export const GRID_SIZE = 1 + GRID_MAX_X - GRID_MIN_X;

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
