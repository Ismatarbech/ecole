<x-layouts::app :title="__('Données')">
    <div class="pagetitle">
        <h1>Données scolaires</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('/') }}">Accueil</a></li><li class="breadcrumb-item active">Données</li></ol></nav>
    </div>

    <div class="alert alert-light border shadow-sm mb-4">
        <i class="bi bi-calendar-check text-primary me-2"></i>
        Année active : <strong>{{ $anneeActive?->scolaire_annee ?? 'Aucune année active' }}</strong>
    </div>

    <section class="section">
        <div class="row g-4">
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Inscriptions mensuelles</h5><div id="inscriptionsChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Revenus mensuels</h5><div id="revenusChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Élèves par classe</h5><div id="classesChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Filles et garçons</h5><div id="sexeClasseChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Revenus par classe</h5><div id="revenusClasseChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Revenus cumulés</h5><div id="cumulChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Paiements par mode</h5><div id="modesChart"></div></div></div></div>
            <div class="col-lg-6"><div class="card"><div class="card-body"><h5 class="card-title">Élèves par niveau</h5><div id="niveauxChart"></div></div></div></div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const money = value => new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
            const months = @json($nomsMois);
            const common = { chart: { height: 320, toolbar: { show: false } }, dataLabels: { enabled: false }, legend: { position: 'bottom' }, noData: { text: 'Aucune donnée disponible' } };
            const render = (id, options) => new ApexCharts(document.querySelector('#' + id), { ...common, ...options }).render();

            render('inscriptionsChart', { chart: { ...common.chart, type: 'line' }, series: [{ name: 'Inscriptions', data: @json($inscriptionsParMois) }], colors: ['#4154f1'], stroke: { curve: 'smooth', width: 3 }, xaxis: { categories: months } });
            render('revenusChart', { chart: { ...common.chart, type: 'area' }, series: [{ name: 'Revenus', data: @json($revenusParMois) }], colors: ['#2eca6a'], stroke: { curve: 'smooth', width: 3 }, fill: { opacity: .28 }, xaxis: { categories: months }, tooltip: { y: { formatter: money } }, yaxis: { labels: { formatter: money } } });
            render('classesChart', { chart: { ...common.chart, type: 'bar' }, series: [{ name: 'Élèves', data: @json($elevesParClasse->pluck('value')) }], colors: ['#4154f1'], plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } }, xaxis: { categories: @json($elevesParClasse->pluck('label')) } });
            render('modesChart', { chart: { ...common.chart, type: 'pie' }, series: @json($paiementsParMode->pluck('value')), labels: @json($paiementsParMode->pluck('label')), colors: ['#4154f1', '#2eca6a', '#ff771d', '#6f42c1'], tooltip: { y: { formatter: money } } });
            render('sexeClasseChart', { chart: { ...common.chart, type: 'bar', stacked: true }, series: [{ name: 'Filles', data: @json($fillesParClasse) }, { name: 'Garçons', data: @json($garconsParClasse) }], colors: ['#e83e8c', '#0d6efd'], plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } }, xaxis: { categories: @json($classesLabels) } });
            render('niveauxChart', { chart: { ...common.chart, type: 'donut' }, series: @json($elevesParNiveau->pluck('value')), labels: @json($elevesParNiveau->pluck('label')), colors: ['#4154f1', '#2eca6a', '#ff771d', '#6f42c1', '#20c997'] });
            render('revenusClasseChart', { chart: { ...common.chart, type: 'bar' }, series: [{ name: 'Revenus', data: @json($paiementsParClasse->pluck('value')) }], colors: ['#ff771d'], plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } }, xaxis: { categories: @json($paiementsParClasse->pluck('label')) }, tooltip: { y: { formatter: money } }, yaxis: { labels: { formatter: money } } });
            render('cumulChart', { chart: { ...common.chart, type: 'area' }, series: [{ name: 'Revenus cumulés', data: @json($revenusCumules) }], colors: ['#6f42c1'], stroke: { curve: 'smooth', width: 3 }, fill: { opacity: .28 }, xaxis: { categories: months }, tooltip: { y: { formatter: money } }, yaxis: { labels: { formatter: money } } });
        });
    </script>
</x-layouts::app>
