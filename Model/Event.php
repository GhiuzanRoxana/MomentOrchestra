<?php

class Event implements CrudInterface
{

    private $db;
    private $table = 'events';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO {$this->table} (id_event, title, event_date, location_id, description, status_id) 
                  VALUES (:id, :title, :date, :location, :description, :status)";

        $stmt = $this->db->prepare($query);
        $id = 'EVT_' . uniqid();

        $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':date' => $data['event_date'],
            ':location' => $data['location_id'],
            ':description' => $data['description'],
            ':status' => $data['status_id'] ?? 1
        ]);

        return $id;
    }

    public function read(string $id)
    {
        $query = "SELECT e.*, l.location_name, l.city, es.status_name 
                  FROM {$this->table} e
                  LEFT JOIN locations l ON e.location_id = l.id_location
                  LEFT JOIN event_status es ON e.status_id = es.id_event_status
                  WHERE e.id_event = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function readAll(): array
    {
        $query = "SELECT e.*, l.location_name, l.city, es.status_name 
                  FROM {$this->table} e
                  LEFT JOIN locations l ON e.location_id = l.id_location
                  LEFT JOIN event_status es ON e.status_id = es.id_event_status
                  ORDER BY e.event_date DESC";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function update(string $id, array $data): bool
    {
        $query = "UPDATE {$this->table} SET title = :title, event_date = :date, 
                  location_id = :location, description = :description, status_id = :status 
                  WHERE id_event = :id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':date' => $data['event_date'],
            ':location' => $data['location_id'],
            ':description' => $data['description'],
            ':status' => $data['status_id'],
            ':id' => $id
        ]);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_event = :id");
        return $stmt->execute([':id' => $id]);
    }
}
