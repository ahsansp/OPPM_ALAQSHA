<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Calendar as EventModel;

class Calendar extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function index()
    {
        return view('calendar');
    }

    public function fetchEvents()
    {
        $events = $this->eventModel->findAll();
        return $this->response->setJSON($events);
    }

    public function updateEvent()
    {
        $id = $this->request->getPost('id');
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('end'),
        ];

        $this->eventModel->update($id, $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function addEvent()
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('end'),
        ];

        $this->eventModel->insert($data);
        return $this->response->setJSON(['success' => true]);
    }
}
