<script type="text/javascript">
  $(function() {
    // WAIT FOR DOM
    // Draw Bar chartist.js
    var data = {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                series: [
                        // TODO get this data from db
                        [2250,2000,1976,500,2300,2100,1100,500,3800,2500,2000,1600],
                        [2241,2122]
                        ]
    };
    var options = {
                  showPoint: true,
                  lineSmooth: true,
                  fullWidth: true,
                  chartPadding: { right: 20, left: 10, bottom: 10 },
                  axisX: { showGrid: false },
                  axisY: { showLabel: true },
                  low: 0
    };

    var chart = new Chartist.Line('#reportStatsLine', data, options);
    chart.on('draw', function(data) {
      if(data.type === 'line' || data.type === 'area') {
        data.element.animate({
          d: {
            begin: 500 * data.index,
            dur: 2000,
            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
            to: data.path.clone().stringify(),
            easing: Chartist.Svg.Easing.easeOutQuint
          }
        });
      }
    });
});
</script>
<div id="reportStatsLine" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
