<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RaceYear;
use Config\Strankovani;

class Main extends BaseController
{   
    protected RaceYear $raceYearModel;
    protected Strankovani $paginationConfig;

    public function __construct()
    {
        $this->raceYearModel = new RaceYear();
        $this->paginationConfig = new Strankovani();

    }

    public function index()
    {
    $years = $this->raceYearModel
        ->select('year, COUNT(*) as race_count')
        ->where('sex', 'W')
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->findAll();

    return view('index', [
        'years' => $years
    ]);
    }

    public function rokDetail($year)
    {
    $data = $this->raceYearModel
        ->where('sex', 'W')
        ->where('year', $year)
        ->orderBy('start_date', 'ASC')
        ->paginate($this->paginationConfig->pocetZavoduNaStranku);

    return view('rokDetail', [
        'data' => $data,
        'year' => $year,
        'pager' => $this->raceYearModel->pager
    ]);
    }

    public function zavodDetail($id){
        $zavody = $this->raceYearModel
        ->select('race_year.*, stage.profile')
        ->where('race_year.id', $id)
        ->join('stage', 'stage.id_race_year=race_year.id')
        ->first();

        return view('zavodDetail', [
            'zavody' => $zavody
        ]);
    }
}
