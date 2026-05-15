<?=$this->extend("layout/template");?>
<?=$this->section("content");?>

<div class="container py-5">

    <!-- Nadpis -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">
            <?=$zavody->real_name ?>
        </h1>

        <p class="text-muted fs-5">
            <?php
            $startDate = date('d.m.Y', strtotime($zavody->start_date));
            $endDate   = date('d.m.Y', strtotime($zavody->end_date));

            if ($zavody->start_date == $zavody->end_date) {
                echo $startDate;
            } else {
                echo $startDate . " - " . $endDate;
            }
            ?>
        </p>
    </div>

    <div class="row g-4">
        <!-- Logo -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h4 class="mb-4">
                        Logo závodu
                    </h4>
                    <img 
                        src="<?= base_url('images/loga/' . $zavody->logo) ?>"
                        class="img-fluid rounded"
                        alt="Logo závodu">
                </div>
            </div>
        </div>

        <!-- Profil tratě -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h4 class="mb-4 text-center">
                        Profil tratě
                    </h4>
                    <img 
                        src="<?= base_url('images/profiles/' . $zavody->profile) ?>"
                        class="img-fluid rounded w-100"
                        alt="Profil tratě">
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->endSection();?>