<?php

class EventController extends BaseController
{

    private $eventModel;

    public function __construct()
    {
        parent::__construct();
        $this->eventModel = new Event();
    }

    public function index()
    {
        return $this->eventModel->readAll();
    }

    public function show($id)
    {
        return $this->eventModel->read($id);
    }

    public function create($data)
    {
        $this->requireAdmin();

        try {
            $this->validate($data, [
                'title' => 'required',
                'event_date' => 'required',
                'location_id' => 'required'
            ]);

            $cleanData = [
                'title' => $this->sanitize($data['title']),
                'event_date' => $data['event_date'],
                'location_id' => $data['location_id'],
                'description' => $this->sanitize($data['description'] ?? ''),
                'status_id' => $data['status_id'] ?? 1
            ];

            $eventId = $this->eventModel->create($cleanData);
            return ['success' => true, 'event_id' => $eventId];
        } catch (ValidationException $e) {
            return ['success' => false, 'errors' => json_decode($e->getMessage(), true)];
        }
    }

    public function update($id, $data)
    {
        $this->requireAdmin();
        return $this->eventModel->update($id, $data);
    }

    public function delete($id)
    {
        $this->requireAdmin();
        return $this->eventModel->delete($id);
    }
}
