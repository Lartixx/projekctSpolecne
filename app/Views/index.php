<?=$this->extend("layout/template");?>
<?=$this->section("content");?>

<style>
    .race-card {
        transition: all 0.2s ease-in-out;
    }

    .race-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<div class="container py-5">

    <!-- Nadpis -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">
            Ženské závody
        </h1>

        <p class="text-muted">
            Přehled závodů podle jednotlivých roků
        </p>
    </div>

    <div class="row">

        <?php foreach ($years as $year): ?>

            <div class="col-md-6 col-lg-4 mb-4">

                <div class="card race-card border-0 shadow-lg h-100 rounded-4">

                    <div class="card-body d-flex flex-column justify-content-center text-center p-5">

                        <!-- Rok -->
                        <h2 class="display-5 fw-bold mb-3">
                            <?= $year->year ?>
                        </h2>

                        <!-- Počet závodů -->
                        <p class="fs-5 text-muted mb-4">
                            Počet závodů:
                            <span class="fw-bold text-dark">
                                <?= $year->race_count ?>
                            </span>
                        </p>

                        <!-- Tlačítko -->
                        <a href="<?= base_url('rokDetail/' . $year->year) ?>"
                           class="btn btn-primary btn-lg rounded-pill px-4">
                            Zobrazit závody
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?=$this->endSection();?>