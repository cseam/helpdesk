<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM
	// Draw Bar chartist.js
	var data = {
		labels: ['test','test2','test3'],
		series: [
			['3','3','3'],
			['3','3','3'],
			['3','3','3'],
			['3','3','3'],
			['3','3','3'],
			['3','3','3'],
			['3','3','3']
			]
		};
	var options = {
		chartPadding: 20,
		fullWidth: true,
		horizontalBars: true,
		stackBars: true,
		reverseData: true,
		seriesBarDistance: 10,
		axisY: {
			onlyInteger: true,
			offset: 100
			},
		axisX: {
			onlyInteger: true
			}
		};
	new Chartist.Bar('#teamperformance', data, options);
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
<div style="float:right;margin-top: -25px;margin-right: 20px;">
  <span style="font-size: 0.6rem;color: white;background: #BFCC80;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-6 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #FFA38B;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-5 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #FDD26E;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-4 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #C09C83;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-3 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #B8CCEA;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-2 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #BFCEC2;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-1 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #D1CCBD;padding: 0.2rem 0.5rem;">Today</span>
</div>
