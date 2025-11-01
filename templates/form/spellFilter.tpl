<form action="%1$s" method="post" style="display: flex;">
	<div class="col-3">
    	<label class="float-start"><input type="checkbox" id="selectAllClass" name="selectAllClass" value="1" data-target="classFilter"%2$s> Classe (<span id="nbClasses">%3$s</span>)</label><br>
        <select id="classFilter" name="classFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%4$s</select>
    </div>
    <div class="col-3">
        <label class="float-start"><input type="checkbox" id="selectAllSchool" name="selectAllSchool" value="1" data-target="schoolFilter"%5$s> École (<span id="nbEcoles">%6$s</span>)</label><br>
        <select id="schoolFilter" name="schoolFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%7$s</select>
    </div>
    <div class="col-3">
        <label class="float-start"> Niveaux</label><br>
        <div class="input-group input-group-sm mb-3">
          <label class="input-group-text" for="levelMinFilter">Min</label>
          <select class="form-select" id="levelMinFilter" name="levelMinFilter">%8$s</select>
          <label class="input-group-text" for="levelMaxFilter">Max</label>
          <select class="form-select" id="levelMaxFilter" name="levelMaxFilter">%9$s</select>
          <label class="input-group-text">&nbsp;</label>
        </div>
    </div>
    <div class="col-3" style="display: flex;">
    	<input type="hidden" name="nbPerPage" value ="%10$s"/>
       	<button type="submit" name="spellFilter" value="Filtrer" class="btn btn-secondary btn-sm" style="margin-top: auto;margin-left: auto;">Filtrer</button>
    </div>
</form>