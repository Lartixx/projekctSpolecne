<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>

<div class="container py-5">

    <!-- Nadpis -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">
            <?= $zavody->real_name ?>
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

    <div class="mb-4">
        <a href="<?= base_url('rokDetail/' . $zavody->year) ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Zpět
        </a>
    </div>

    <div class="row g-4">

        <!-- Logo -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <h4 class="mb-4">
                        Logo závodu
                    </h4>

                    <hr class="border-2 border-secondary opacity-25 mb-4">

                    <?php if (!empty($zavody->logo)): ?>

                        <div class="d-flex justify-content-center align-items-center"
                            style="min-height: 300px;">

                            <img
                                src="<?= base_url('images/logos/' . $zavody->logo) ?>"
                                class="img-fluid rounded"
                                style="max-height: 250px;"
                                alt="Logo závodu">

                        </div>

                    <?php else: ?>

                        <div class="d-flex justify-content-center align-items-center flex-column text-muted"
                            style="min-height: 300px;">
                            
                                <i class="fas fa-image fa-3x mb-3"></i>
                        

                           
                                <p class="mb-0">
                                    Není nahrané logo
                                </p>
                         
                        </div>

                    <?php endif; ?>

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

                    <hr class="border-2 border-secondary opacity-25 mb-4">

                    <?php if (!empty($zavody->profile)): ?>

                        <div class="d-flex justify-content-center align-items-center"
                            style="min-height: 300px;">

                            <img
                                src="<?= base_url('images/stages/profiles/' . $zavody->profile) ?>"
                                class="img-fluid rounded"
                                style="max-height: 300px;"
                                alt="Profil tratě">

                        </div>

                    <?php else: ?>

                        <div class="d-flex justify-content-center align-items-center flex-column text-muted"
                            style="min-height: 300px;">

                            <i class="fas fa-map fa-3x mb-3"></i>

                            <p class="mb-0">
                                Není nahraná mapa
                            </p>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <?= $this->endSection(); ?>