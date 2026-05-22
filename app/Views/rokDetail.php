<?=$this->extend("layout/template");?>
<?=$this->section("content");?>

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
    <a href="' . base_url('zavody/edit/' . $row->id) . '" 
       class="btn btn-sm btn-success d-flex align-items-center justify-content-center"
       title="Upravit">
        <i class="fa fa-pencil"></i>
    </a>
';

// Smazat tlačítko
$deleteButton = '
    <a href="' . base_url('zavody/delete/' . $row->id) . '" 
       class="btn btn-sm btn-danger d-flex align-items-center justify-content-center"
       title="Smazat"
       onclick="return confirm(\'Opravdu chceš smazat tento záznam?\')">
        <i class="fa fa-trash"></i>
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

<?=$this->endSection();?>