<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RaceYear;

class Main extends BaseController
{   
    protected RaceYear $raceYearModel;

    public function __construct()
    {
        $this->raceYearModel = new RaceYear();
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
        ->findAll();

    return view('rokDetail', [
        'data' => $data,
        'year' => $year
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
