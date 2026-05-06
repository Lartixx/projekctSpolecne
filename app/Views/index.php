<?=$this->extend("layout/template");?>
<?=$this->section("content");?>

<div>
    <div class="text-center">
        <h1>Seznam ženských závodů</h1>
    </div>

<?php  

$table = new \CodeIgniter\View\Table();

$table->setHeading('Název', 'Rok', 'Datum', 'Zjistit víc');

foreach ($data as $row) {

    if ($row->start_date == $row->end_date) {
        $datum = $row->start_date;
    } else {
        $datum = $row->start_date . "-" . $row->end_date;
    }

    $table->addRow($row->real_name, $row->year, $datum, $row->id);
}
 
$template = array(
    'table_open'=> '<table class="table table-bordered">',
    'thead_open'=> '<thead>',
    'thead_close'=> '</thead>',
    'heading_row_start'=> '<tr>',
    'heading_row_end'=>' </tr>',
    'heading_cell_start'=> '<th>',
    'heading_cell_end' => '</th>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end'  => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
    );
   
$table->setTemplate($template);
    // $page = $pager->getCurrentPage();
    echo $table->generate();
    // echo $pager->links();

 
?>
</div>

<?=$this->endSection();?>