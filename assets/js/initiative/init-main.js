import { initHeader } from "./init-header.js";
import { initAsideParty } from "./init-aside-party.js";
import { initMainContent } from "./init-main-content.js";
import { updateCombatAudio } from "./init-audio.js";
import { initAsideMonsters } from "./init-aside-monsters.js";

$(function () {
    initHeader();
    initAsideParty();
    initMainContent();
    initAsideMonsters();

    updateCombatAudio();
});
