<form action="%1$s" method="post" style="display: flex;" id="formFilter">
    <div class="col-3" style="display: flex; flex-direction:column;">
    	<label class="text-start"><input type="checkbox" id="onlyRituel" name="onlyRituel" value="1"%10$s> Rituels</label><br>
    	<label class="text-start"><input type="checkbox" id="onlyConcentration" name="onlyConcentration" value="1"%11$s> Concentration</label><br>
    	<input type="hidden" id="nbPerPage" name="nbPerPage" value ="%12$s"/>
    	<input type="hidden" id="refElementId" name="refElementId" value ="%13$s"/>
    	<input type="hidden" id="spellFilter" name="spellFilter" value ="Filtrer"/>
       	<button type="submit" class="btn btn-secondary btn-sm" style="margin-top: auto;margin-left: auto;">Filtrer</button>
    </div>
</form>