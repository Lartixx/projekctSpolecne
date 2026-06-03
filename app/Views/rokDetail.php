<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="container py-5">

    <!-- Nadpis -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">
            Seznam ženských závodů - <?= $year ?>
        </h1>
        <p class="text-muted">
            Přehled všech dostupných závodů
        </p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- Zpět -->
        <a href="<?= base_url('/') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Zpět
        </a>

        <!-- Přidat -->
        <!-- BUTTON -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createWomenRaceModal">
            <i class="fas fa-plus me-1"></i> Přidat závod
        </button>

        <!-- MODAL -->
        <div class="modal fade" id="createWomenRaceModal" tabindex="-1" aria-labelledby="createWomenRaceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="<?= base_url('zavody/create') ?>" method="post" enctype="multipart/form-data">

                        <div class="modal-header">
                            <h5 class="modal-title" id="createWomenRaceModalLabel">
                                Přidat ženský závod
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row">

                                <!-- Název -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Název závodu</label>

                                    <input type="text"
                                        name="real_name"
                                        class="form-control"
                                        required>
                                </div>

                                <!-- Ročník -->



                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ročník</label>

                                    <input type="text"
                                       
                                        class="form-control"
                                        value="<?= $year ?>"
                                        disabled>
                                </div>



                                <input type="hidden"
                                    name="year"
                                    value="<?= $year ?>">

                                <!-- Datum od -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Datum začátku</label>

                                    <input type="date"
                                        name="start_date"
                                        class="form-control"
                                        min="<?= $year ?>-01-01"
                                        max="<?= $year ?>-12-31"
                                        required>
                                </div>

                                <!-- Datum do -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Datum konce</label>

                                    <input type="date"
                                        name="end_date"
                                        class="form-control"
                                        min="<?= $year ?>-01-01"
                                        max="<?= $year ?>-12-31"
                                        required>
                                </div>




                                <!-- Stát -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stát</label>

                                    <select name="country" class="form-select" required>
                                        <option value="">Vyber stát</option>

                                        <?php foreach ($countries as $country): ?>

                                            <option value="<?= esc($country['alpha2']) ?>">
                                                <?= esc($country['name']) ?> (<?= esc($country['alpha2']) ?>)
                                            </option>

                                        <?php endforeach; ?>

                                    </select>
                                </div>

                                <!-- Logo -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Logo</label>

                                    <input type="file"
                                        name="logo"
                                        class="form-control"
                                        accept=".png,.jpg,.jpeg,.svg"
                                        required>
                                </div>

                                <!-- id_race -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Závod</label>

                                    <select name="id_race" class="form-select" required>
                                        <option value="">Vyber závod</option>

                                        <?php foreach ($races as $race): ?>

                                            <option value="<?= $race->id ?>">
                                                <?= esc($race->default_name) ?> (ID: <?= $race->id ?>)
                                            </option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Zavřít
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Uložit závod
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- prázdné místo kvůli vycentrování -->
        <div style="width: 90px;"></div>

    </div>

    <?php

    $table = new \CodeIgniter\View\Table();

    $table->setHeading(
        ['data' => 'Název', 'class' => 'text-center'],
        ['data' => 'Rok', 'class' => 'text-center'],
        ['data' => 'Datum', 'class' => 'text-center'],
        ['data' => 'Zjistit víc', 'class' => 'text-center'],
        ['data' => 'Upravit', 'class' => 'text-center']
    );

    foreach ($data as $row) {

        // Formátování datumu
        $startDate = date('d.m.Y', strtotime($row->start_date));
        $endDate   = date('d.m.Y', strtotime($row->end_date));

        // Pokud jsou datumy stejné → vypíše jen jeden
        if ($row->start_date == $row->end_date) {
            $datum = $startDate;
        } else {
            $datum = $startDate . " - " . $endDate;
        }

        // Tlačítko detailu
        $detailButton = '
        <a href="' . base_url('zavodDetail/' . $row->id) . '" 
           class="btn btn-sm btn-primary">
            Detail
        </a>
    ';

        // Edit tlačítko
        $editButton = '

<button type="button"
    class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#editRaceModal' . $row->id . '">

    <i class="fas fa-pencil-alt me-1"></i>
    Upravit

</button>

<div class="modal fade"
    id="editRaceModal' . $row->id . '"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form action="' . base_url('zavody/update/' . $row->id) . '"
                method="post"
                enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Upravit závod
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- Název -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Název závodu
                            </label>

                            <input type="text"
                                name="real_name"
                                class="form-control"
                                value="' . esc($row->real_name) . '"
                                required>
                        </div>

                        <!-- Ročník -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Ročník
                            </label>

                            <input type="text"
                                class="form-control"
                                value="' . $row->year . '"
                                disabled>
                        </div>

                        <!-- Datum začátku -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Datum začátku
                            </label>

                            <input type="date"
                                name="start_date"
                                class="form-control"
                                value="' . $row->start_date . '"
                                min="' . $row->year . '-01-01"
                                max="' . $row->year . '-12-31"
                                required>
                        </div>

                        <!-- Datum konce -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Datum konce
                            </label>

                            <input type="date"
                                name="end_date"
                                class="form-control"
                                value="' . $row->end_date . '"
                                min="' . $row->year . '-01-01"
                                max="' . $row->year . '-12-31"
                                required>
                        </div>

                        <!-- Stát -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Stát
                            </label>

                            <select name="country"
                                class="form-select"
                                required>';

        foreach ($countries as $country) {

            $selected = $row->country == $country['alpha2'] ? 'selected' : '';

            $editButton .= '

                                <option value="' . esc($country['alpha2']) . '" ' . $selected . '>
                                    ' . esc($country['name']) . ' (' . esc($country['alpha2']) . ')
                                </option>
    ';
        }

        $editButton .= '

                            </select>
                        </div>

                        <!-- Závod -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Závod
                            </label>

                            <select name="id_race"
                                class="form-select"
                                required>';

        foreach ($races as $race) {

            $selected = $row->id_race == $race->id ? 'selected' : '';

            $editButton .= '

                                <option value="' . $race->id . '" ' . $selected . '>
                                    ' . esc($race->default_name) . ' (ID: ' . $race->id . ')
                                </option>
    ';
        }

        $editButton .= '

                            </select>
                        </div>

                        <!-- Aktuální logo -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Aktuální logo
                            </label>

                            <div class="border rounded p-2 text-center bg-light">';

        if (!empty($row->logo)) {

            $editButton .= '

                                    <img src="' . base_url('images/logos/' . $row->logo) . '"
                                        class="img-fluid"
                                        style="max-height: 120px;">
                                ';
        } else {

            $editButton .= '

                                    <span class="text-muted">
                                        Žádné logo
                                    </span>
                                ';
        }

        $editButton .= '

                            </div>
                        </div>

                        <!-- Nové logo -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Nové logo
                            </label>

                            <input type="file"
                                name="logo"
                                class="form-control"
                                accept=".png,.jpg,.jpeg,.svg">
                        </div>

                        <!-- Aktuální mapa -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Aktuální mapa
                            </label>

                            <div class="border rounded p-2 text-center bg-light">';

        if (!empty($row->map)) {

            $editButton .= '

                                    <img src="' . base_url('images/stages/profiles/' . $row->map) . '"
                                        class="img-fluid"
                                        style="max-height: 120px;">
                                ';
        } else {

            $editButton .= '

                                    <span class="text-muted">
                                        Žádná mapa
                                    </span>
                                ';
        }

        $editButton .= '

                            </div>
                        </div>

                        <!-- Nová mapa -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Nová mapa
                            </label>

                            <input type="file"
                                name="map"
                                class="form-control"
                                accept=".png,.jpg,.jpeg,.webp,.svg">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Zavřít

                    </button>

                    <button type="submit"
                        class="btn btn-warning">

                        <i class="fas fa-save me-1"></i>
                        Uložit změny

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

';

        // Smazat tlačítko
        $deleteButton = '
    <a href="' . base_url('zavody/delete/' . $row->id) . '" 
       class="btn btn-danger btn-sm"
       title="Smazat"
       onclick="return confirm(\'Opravdu chceš smazat tento záznam?\')">
        <i class="fas fa-trash me-1"></i> Smazat
    </a>
';

        // poslední sloupec (Upravit)
        $actionButtons = '
    <div class="d-flex justify-content-center gap-2">
        ' . $editButton . '
        ' . $deleteButton . '
    </div>
';

        $table->addRow(
            $row->real_name,
            $row->year,
            $datum,
            $detailButton,
            $actionButtons
        );
    }

    $template = array(
        'table_open' => '
        <table class="table table-hover table-striped table-bordered align-middle shadow-sm">
    ',

        'thead_open' => '<thead class="table-dark">',
        'thead_close' => '</thead>',

        'heading_row_start' => '<tr>',
        'heading_row_end' => '</tr>',

        'heading_cell_start' => '<th class="text-center">',
        'heading_cell_end' => '</th>',

        'tbody_open' => '<tbody>',
        'tbody_close' => '</tbody>',

        'row_start' => '<tr>',
        'row_end' => '</tr>',

        'cell_start' => '<td class="text-center">',
        'cell_end' => '</td>',

        'row_alt_start' => '<tr>',
        'row_alt_end' => '</tr>',

        'cell_alt_start' => '<td class="text-center">',
        'cell_alt_end' => '</td>',

        'table_close' => '</table>'
    );

    $table->setTemplate($template);

    echo $table->generate();

    ?>

    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links() ?>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const startDate = document.querySelector('input[name="start_date"]');
        const endDate = document.querySelector('input[name="end_date"]');

        // když změním začátek
        startDate.addEventListener('change', function() {

            // konec nesmí být menší než začátek
            endDate.min = startDate.value;

            // pokud už je konec menší, smaže se
            if (endDate.value && endDate.value < startDate.value) {
                endDate.value = '';
            }
        });

        // když změním konec
        endDate.addEventListener('change', function() {

            // začátek nesmí být větší než konec
            startDate.max = endDate.value;

            // pokud už je začátek větší, smaže se
            if (startDate.value && startDate.value > endDate.value) {
                startDate.value = '';
            }
        });

    });
</script>

<?= $this->endSection(); ?>