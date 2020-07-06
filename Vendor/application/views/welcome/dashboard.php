<link href="<?php echo base_url(); ?>assets/global/gcg/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/global/gcg/vendor/select2/select2.min.css" rel="stylesheet">

<style>
	p.small {
		line-height: 0.7;
	}

	p.big {
		line-height: 1.8;
	}
	#peta {
		height: 600px; 
		min-width: 310px; 
		max-width: 1360px; 
		margin: 0 auto; 
	}
	.loading {
		margin-top: 10em;
		text-align: center;
		color: gray;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow">
				<div class="card-body">
					<div class="row">
						<div id="peta"></div>
					</div>
					<div class="row">
						<label>Total Vendor : <?=$total_vendor;?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script>

<script>
	$(document).ready(function() {
		Layout.init();
		$('#run').click(function () {     
			var geojson = $.parseJSON($('#geojson').val());

			// Initiate the chart
			$('#peta').slideDown().highcharts('Map', {
				series: [{
					mapData: geojson
				}]
			});    
		});
	});

	var data = [
		['id-3700', 20],
		['id-ac', <?=$prov_id['11'];?>], //aceh
		['id-jt', <?=$prov_id['33'];?>], 
		['id-be', <?=$prov_id['17'];?>], //
		['id-bt', <?=$prov_id['36'];?>],
		['id-kb', <?=$prov_id['61'];?>],
		['id-bb', <?=$prov_id['19'];?>],
		['id-ba', <?=$prov_id['51'];?>],
		['id-ji', <?=$prov_id['35'];?>],
		['id-ks', <?=$prov_id['63'];?>],
		['id-nt', <?=$prov_id['53'];?>],
		['id-se', <?=$prov_id['73'];?>],
		['id-kr', <?=$prov_id['21'];?>],
		['id-ib', <?=$prov_id['91'];?>],
		['id-su', <?=$prov_id['12'];?>],
		['id-ri', <?=$prov_id['14'];?>],
		['id-sw', <?=$prov_id['71'];?>],
		['id-ku', <?=$prov_id['65'];?>],
		['id-la', <?=$prov_id['82'];?>],
		['id-sb', <?=$prov_id['13'];?>],
		['id-ma', <?=$prov_id['81'];?>],
		['id-nb', <?=$prov_id['52'];?>],
		['id-sg', <?=$prov_id['74'];?>],
		['id-st', <?=$prov_id['72'];?>],
		['id-pa', <?=$prov_id['92'];?>],
		['id-jr', <?=$prov_id['32'];?>],
		['id-ki', <?=$prov_id['64'];?>],
		['id-1024', <?=$prov_id['18'];?>], //lampung
		['id-jk', <?=$prov_id['31'];?>], //jakarta
		['id-go', <?=$prov_id['75'];?>],
		['id-yo', <?=$prov_id['34'];?>],
		['id-sl', <?=$prov_id['16'];?>],
		['id-sr', <?=$prov_id['76'];?>],
		['id-ja', <?=$prov_id['15'];?>],
		['id-kt', <?=$prov_id['62'];?>]
	];

	// Create the chart
	Highcharts.mapChart('peta', {
		chart: {
			map: 'countries/id/id-all'
		},
		title: {
			text: 'PETA PERSEBARAN VENDOR'
		},
		subtitle: {
			text: 'PT. ENERGI PELABUHAN INDONESIA (PT.EPI)'
		},
		mapNavigation: {
			enabled: true,
			buttonOptions: {
				verticalAlign: 'bottom'
			}
		},
		colorAxis: {
			min: 0
		},
		series: [{
			data: data,
			name: 'Jumlah Vendor',
			states: {
				hover: {
					color: '#33DA55'
				}
			},
			dataLabels: {
				enabled: false,
				format: '{point.name}'
			}
		}]
	});
</script>