<meta charset="utf-8">
<script src="./js/jquery-1.12.0.min.js"></script>
<script src="./js/jquery-migrate-1.2.1.min.js"></script>
<script src="./js/highcharts.js"></script>
<script src="./js/modules/exporting.js"></script>
<div id="topdiv" class="row" style="margin-top:40px;">
	<div class="col-md-3">
		<select id="catdom">
			<option value="1">categorie</option>
			<option value="2">domaine</option>
		</select>
	</div>
	<div class="col-md-3">
		<div class="col-md-12">date de début
			<input type="month" id="begindate">
					</div>

		<div class="col-md-12"><br>date de fin
			<input type="month" id="enddate">
		</div>
		<div class="col-md-12">
			<br>

			<button id="generate"  class="col-md-12 btn btn-primary">generer un graphique</button>
		</div>
	</div>
</div>
<div class="col-md-12" id="retour"><div>