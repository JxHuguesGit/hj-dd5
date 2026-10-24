export function updateCombatAudio() {
    const audio = $('#combat-audio').get(0);
    
    if (!audio) {
        return;
    }

    const combatStarted = $('#main-content').hasClass("combatStarted");

    if (combatStarted) {
        if (audio.paused) {
            audio.play().catch((error) => {
                console.warn("Lecture audio impossible :", error);
            });
        }
    } else {
        audio.pause();
        audio.currentTime = 0;
    }
}
