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
            ->join('stage', 'stage.id_race_year=race_year.id', 'left')
            ->first();

        return view('zavodDetail', [
            'zavody' => $zavody
        ]);
    }

    public function uploadFile($file, $path, $name)
    {
        $extension = $file->getClientExtension();
        $fullName = $name . "." . $extension;
        $result = $file->move($path, $fullName);
        $return['uploaded'] = $result;
        $return['name'] = $fullName;
        return $return;
    }

    public function create()
    {
        $logo = $this->request->getFile('logo');
        $uploadPath = 'images/logos/';
        $name = 'logo-' . uniqid();


        $uploadResult = $this->uploadFile($logo, $uploadPath, $name);

        if (!$uploadResult['uploaded']) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setBody('Chyba při nahrávání souboru');
        }

        $logoName = $uploadResult['name'];

        $data = [

            'real_name' => $this->request->getPost('real_name'),

            'id_race' => $this->request->getPost('id_race'),

            'year' => $this->request->getPost('year'),

            'start_date' => $this->request->getPost('start_date'),

            'end_date' => $this->request->getPost('end_date'),

            'country' => $this->request->getPost('country'),

            'logo' => $logoName,

            'sex' => 'W'
        ];

        $result = $this->raceYearModel->save($data);


        return redirect()->to('/rokDetail/' . $data['year'])
            ->with('success', 'Závod byl úspěšně vytvořen');
    }
}
