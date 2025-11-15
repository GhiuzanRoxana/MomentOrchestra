<?php

class Reservation implements CrudInterface
{

    private $db;
    private $table = 'reservations';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO {$this->table} (id_user, id_event, price, status, reservation_date) 
                  VALUES (:user_id, :event_id, :price, :status, CURRENT_TIMESTAMP)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':user_id' => $data['id_user'],
            ':event_id' => $data['id_event'],
            ':price' => $data['price'] ?? 0,
            ':status' => $data['status'] ?? 'confirmed'
        ]);
    }

    public function read(string $id)
    {
        list($user_id, $event_id) = explode('_', $id, 2);

        $query = "SELECT r.*, e.title, e.event_date, u.username 
                  FROM {$this->table} r
                  JOIN events e ON r.id_event = e.id_event
                  JOIN users u ON r.id_user = u.id_user
                  WHERE r.id_user = :user_id AND r.id_event = :event_id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $user_id, ':event_id' => $event_id]);
        return $stmt->fetch();
    }

    public function readAll(): array
    {
        $query = "SELECT r.*, e.title, e.event_date, u.username 
                  FROM {$this->table} r
                  JOIN events e ON r.id_event = e.id_event
                  JOIN users u ON r.id_user = u.id_user
                  ORDER BY r.reservation_date DESC";

        return $this->db->query($query)->fetchAll();
    }

    public function update(string $id, array $data): bool
    {
        list($user_id, $event_id) = explode('_', $id, 2);

        $query = "UPDATE {$this->table} SET price = :price, status = :status 
                  WHERE id_user = :user_id AND id_event = :event_id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':price' => $data['price'],
            ':status' => $data['status'],
            ':user_id' => $user_id,
            ':event_id' => $event_id
        ]);
    }

    public function delete(string $id): bool
    {
        list($user_id, $event_id) = explode('_', $id, 2);

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_user = :user_id AND id_event = :event_id");
        return $stmt->execute([':user_id' => $user_id, ':event_id' => $event_id]);
    }

    public function getByUser($user_id)
    {
        $query = "SELECT r.*, e.title, e.event_date, e.description 
                  FROM {$this->table} r
                  JOIN events e ON r.id_event = e.id_event
                  WHERE r.id_user = :user_id
                  ORDER BY e.event_date DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}
