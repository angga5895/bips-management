$(function() {
  var gridBorder = '#eeeeee';
  var data = [
      { period: '2011 Q3', licensed: 71, sorned: 41 },
      { period: '2011 Q2', licensed: 24, sorned: 80 },
      { period: '2011 Q1', licensed: 39, sorned: 28 },
      { period: '2010 Q4', licensed: 34, sorned: 38 },
      { period: '2009 Q4', licensed: 51, sorned: 11 },
      { period: '2008 Q4', licensed: 68, sorned: 67 },
      { period: '2007 Q4', licensed: 85, sorned: 6 },
      { period: '2006 Q4', licensed: 21, sorned: 87 },
      { period: '2005 Q4', licensed: 38, sorned: 94 }
  ];



  new Morris.Line({
    element: 'morrisjs-graph',
    data: data,
    xkey: 'period',
    ykeys: ['licensed'],
    labels: ['Licensed'],
    hoverCallback: function (index, options, content, row) {
        return "" +
            "<div class='text-success'>"+row.period+"</div>" +
            "<div>"+row.licensed+"</div>" +
            "<div>"+row.sorned+"</div>";
    },
    lineWidth: 1,
    pointSize: 4,
    gridLineColor: gridBorder,
    resize: true,
    hideHover: 'auto',
    lineColors: ['#FFC107', '#E91E63'],
  });

  new Morris.Bar({
    element: 'morrisjs-bars',
    data: data,
    xkey: 'period',
    ykeys: ['licensed'],
    labels: ['Licensed'],
    hoverCallback: function (index, options, content, row) {
        return "" +
            "<div class='text-success'>"+row.period+"</div>" +
            "<div>"+row.licensed+"</div>" +
            "<div>"+row.sorned+"</div>";
    },
    barRatio: 0.4,
    xLabelAngle: 35,
    hideHover: 'auto',
    barColors: ['#CDDC39'],
    gridLineColor: gridBorder,
    resize: true
  });

  new Morris.Area({
    element: 'morrisjs-area',
    data: data,
    xkey: 'period',
    ykeys: ['licensed'],
    labels: ['Licensed'],
    hoverCallback: function (index, options, content, row) {
        return "" +
            "<div class='text-success'>"+row.period+"</div>" +
            "<div>"+row.licensed+"</div>" +
            "<div>"+row.sorned+"</div>";
    },
    hideHover: 'auto',
    lineColors: ['#673AB7', '#0288D1', '#9E9E9E'],
    fillOpacity: 0.1,
    behaveLikeLine: true,
    lineWidth: 1,
    pointSize: 4,
    gridLineColor: gridBorder,
    resize: true
  });
});
