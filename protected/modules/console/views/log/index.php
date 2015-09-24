<div>
    <ul>
        <li><a href="<?= SiteHelper::createUrl("/console/log/") ?>">Статистика посещаемости туров</a></li>
        <li><a href="<?= SiteHelper::createUrl("/console/log/toursCountry") ?>">Статистика стран туров</a></li>
        <li><a href="<?= SiteHelper::createUrl("/console/log/toursCategory") ?>">Статистика категорий туров</a></li>
    </ul>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1.1', {packages: ['line']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Дата');
        data.addColumn('number', 'Туры');
        data.addColumn('number', 'Категории');
        data.addColumn('number', 'Страны');

        data.addRows([<?= $rows ?>]);

        var options = {
            chart: {
                title: 'Статистика посещаемости туров',
                subtitle: '-'
            },
            width: 900,
            height: 500
        };

        var chart = new google.charts.Line(document.getElementById('linechart_material'));

        chart.draw(data, options);
    }
</script>

<div id="linechart_material"></div>