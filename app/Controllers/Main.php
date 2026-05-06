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
        $data = $this->raceYearModel->where('sex', 'W')->orderBy('year', 'DESC')->findAll();

        return view ('index', [
            'data' => $data,
        ]);
    }
}
