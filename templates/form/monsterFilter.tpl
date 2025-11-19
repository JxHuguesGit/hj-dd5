<form action="%1$s" method="post" style="display: flex;" id="formFilter">
	<div class="col-3">
    	<label class="float-start"><input type="checkbox" id="selectAllType" name="selectAllType" value="1" data-target="typeFilter"%2$s> Types (<span id="nbTypes">%3$s</span>)</label><br>
        <select id="typeFilter" name="typeFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%4$s</select>
    </div>
    <div class="col-3">
    <!--
        <label class="float-start"><input type="checkbox" id="selectAllSchool" name="selectAllSchool" value="1" data-target="schoolFilter"%5$s> École (<span id="nbEcoles">%6$s</span>)</label><br>
        <select id="schoolFilter" name="schoolFilter[]" class="form-select form-select-sm" size="4" style="padding: 0;" multiple>%7$s</select>
    -->
    </div>
    <div class="col-3">
        <label class="float-start"> <abbr title="Facteur de puissance">FP</abbr></label><br>
        <div class="input-group input-group-sm mb-3">
          <label class="input-group-text" for="fpMinFilter">Min</label>
          <select class="form-select" id="fpMinFilter" name="fpMinFilter">%8$s</select>
          <label class="input-group-text" for="fpMaxFilter">Max</label>
          <select class="form-select" id="fpMaxFilter" name="fpMaxFilter">%9$s</select>
          <label class="input-group-text">&nbsp;</label>
        </div>
    </div>
    <div class="col-3" style="display: flex; flex-direction:column;">
    <!--
    	<label class="text-start"><input type="checkbox" id="onlyRituel" name="onlyRituel" value="1"%10$s> Rituels</label><br>
    	<label class="text-start"><input type="checkbox" id="onlyConcentration" name="onlyConcentration" value="1"%11$s> Concentration</label><br>
    -->
    	<input type="hidden" id="nbPerPage" name="nbPerPage" value ="%12$s"/>
    	<input type="hidden" id="refElementId" name="refElementId" value ="%13$s"/>
    	<input type="hidden" id="monsterFilter" name="monsterFilter" value ="Filtrer"/>
       	<button type="submit" class="btn btn-secondary btn-sm" style="margin-top: auto;margin-left: auto;">Filtrer</button>
    </div>
</form>