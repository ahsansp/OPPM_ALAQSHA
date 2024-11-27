<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Calendar;

class CalendarApi extends ResourceController
{
    protected $format = "json";
    protected $calendarModel;
    public function __construct() {
        $this->calendarModel= new calendar();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $events = $this->calendarModel->findAll();
        $data =[
            'events' => $events
        ];
        echo json_encode($data);
        $this->respond($data, 200);
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
        $santri = $this->calendarModel->findAll();
        $insert = [
            'start' => esc($this->request->getVar('start')),
            'end' => esc($this->request->getVar('end')),
            'title' => esc($this->request->getVar('title')),
            'color' => esc($this->request->getVar('color')),
            'all_day' => esc($this->request->getVar('all_day')),
            'url' => esc($this->request->getVar('url'))
        ];
        $result = $this->calendarModel->insert($insert);
        $this->respondCreated($result);
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
