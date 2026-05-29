<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RaceYear;
use Config\Strankovani;
use League\ISO3166\ISO3166;
use App\Models\Race;

class Main extends BaseController
{
    protected RaceYear $raceYearModel;
    protected Race $raceModel;
    protected Strankovani $paginationConfig;

    public function __construct()
    {
        $this->raceYearModel = new RaceYear();
        $this->raceModel = new Race();
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

        $races = $this->raceModel->findAll();

        $iso3166 = new ISO3166();
        $countries = $iso3166->all();

        return view('rokDetail', [
            'data' => $data,
            'year' => $year,
            'pager' => $this->raceYearModel->pager,
            'countries' => $countries,
            'races' => $races
        ]);
    }

    public function zavodDetail($id)
    {
        $zavody = $this->raceYearModel
            ->select('race_year.*, stage.profile')
            ->where('race_year.id', $id)
            ->join('stage', 'stage.id_race_year=race_year.id')
            ->first();

        return view('zavodDetail', [
            'zavody' => $zavody
        ]);
    }

    public function create()
    {
        

    }
}
