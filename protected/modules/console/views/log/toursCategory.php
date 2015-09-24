<div>
    <ul>
        <li><a href="<?= SiteHelper::createUrl("/console/log/") ?>">Статистика посещаемости туров</a></li>
        <li><a href="<?= SiteHelper::createUrl("/console/log/toursCountry") ?>">Статистика стран туров</a></li>
        <li><a href="<?= SiteHelper::createUrl("/console/log/toursCategory") ?>">Статистика категорий туров</a></li>
    </ul>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Element', '<?= date("m.Y") ?>', '<?= ( date("m") - 1 ).date(".Y") ?>', { role: 'style' } ],
            <?= $rows ?>
        ]);

        var options = {
            chart: {
                title: 'Статистика посещаемости туров',
                subtitle: '-'
            },
            colors: ['#b0120a', '#ffab91'],
            width: 1024,
            height: 1400
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<h2>Стастистика по посещаемости Категорий туров на <?= date("Y-m") ?></h2>
<div id="chart_div"></div>