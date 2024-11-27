<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Santri;
use App\Models\Kobong;
use App\Models\Main;

class PAAPI extends ResourceController
{
    protected $format = "json";
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $mainModel = new Main();
        $santri = $mainModel->getSelect('santri.nama_pendek');
        $post = [
            'title' => esc($this->request->getVar('title')),
            'date' => esc($this->request->getVar('date')),
            'kobong' => esc($this->request->getVar('kobong')),
            'orang' => esc($this->request->getVar('orang')),
        ];
        shuffle($santri);
        $date = date_create($post['date']);
        $json = [];
        for ($i=0; $i < ceil(count($santri) / $post['orang']); $i++) {
            for ($j=0; $j < $post['orang'] ; $j++) { 
                if (($i * $post['orang'] + $j) < count($santri)) {
                    $json[strval(date_timestamp_get($date))][] = $santri[$i * $post['orang'] + $j]->nama_pendek;
                }
            }
            date_add($date, date_interval_create_from_date_string('1 day'));
        }
        $data = [
            'massage'   => 'succes',
            'santri' => $json,
            'data'      => $post,
            'date'      => $date,
        ];
        return $this->respond($data,200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
