<form method="post" style="display: flex;" id="formSpellFilter">
    <div class="row">
        <div class="col-12 mb-3">
            <label class="float-start"> Niveaux</label><br>
            <div class="input-group input-group-sm">
                <label class="input-group-text" for="levelMinFilter">Min</label>
                <select class="form-select" id="levelMinFilter" name="levelMinFilter">%1$s</select>
                <label class="input-group-text" for="levelMaxFilter">Max</label>
                <select class="form-select" id="levelMaxFilter" name="levelMaxFilter">%2$s</select>
                <label class="input-group-text">&nbsp;</label>
            </div>
        </div>
        <div class="col-6 mb-3">
            <label class="float-start"><input type="checkbox" id="selectAllClass" name="selectAllClass" value="1" data-target="classFilter"%3$s> Classes (<span id="nbClasses">%4$s</span>)</label><br>
            <select id="classFilter" name="classFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%5$s</select>
        </div>
        <div class="col-6 mb-3">
            <label class="float-start"><input type="checkbox" id="selectAllSchool" name="selectAllSchool" value="1" data-target="schoolFilter"%6$s> Écoles (<span id="nbEcoles">%7$s</span>)</label><br>
            <select id="schoolFilter" name="schoolFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%8$s</select>
        </div>
        <div class="col-6 mb-3">
            <label class="float-start"><input type="checkbox" id="selectAllSource" name="selectAllSource" value="1" data-target="classFilter"%11$s> Sources (<span id="nbSources">%12$s</span>)</label><br>
            <select id="sourceFilter" name="sourceFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%13$s</select>
        </div>
        <div class="col-6 mb-3">
            <br>
            <label class="text-start"><input type="checkbox" id="onlyRituel" name="onlyRituel" value="1"%9$s> Rituels</label><br>
            <label class="text-start"><input type="checkbox" id="onlyConcentration" name="onlyConcentration" value="1"%10$s> Concentration</label><br>
        </div>
    </div>
</form>
