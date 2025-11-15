<?php

class ReservationController extends BaseController
{

    private $reservationModel;

    public function __construct()
    {
        parent::__construct();
        $this->reservationModel = new Reservation();
    }

    public function create($data)
    {
        $this->requireLogin();

        try {
            $this->validate($data, ['id_event' => 'required']);

            $cleanData = [
                'id_user' => $_SESSION['user_id'],
                'id_event' => $data['id_event'],
                'price' => $data['price'] ?? 0,
                'status' => 'confirmed'
            ];

            $result = $this->reservationModel->create($cleanData);
            return ['success' => true];
        } catch (ValidationException $e) {
            return ['success' => false, 'errors' => json_decode($e->getMessage(), true)];
        }
    }

    public function myReservations()
    {
        $this->requireLogin();
        return $this->reservationModel->getByUser($_SESSION['user_id']);
    }

    public function cancel($id)
    {
        $this->requireLogin();
        return $this->reservationModel->delete($id);
    }

    public function allReservations()
    {
        $this->requireAdmin();
        return $this->reservationModel->readAll();
    }
}
