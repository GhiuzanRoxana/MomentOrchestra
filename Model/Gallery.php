<?php

class Gallery implements CrudInterface
{

    private $db;
    private $table = 'gallery_photos';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO {$this->table} (id_user, photo_path, title, description, upload_date, uploaded_by_user_id) 
                  VALUES (:id, :path, :title, :description, CURRENT_TIMESTAMP, :uploaded_by)";

        $stmt = $this->db->prepare($query);
        $id = 'PHOTO_' . uniqid();

        $stmt->execute([
            ':id' => $id,
            ':path' => $data['photo_path'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? '',
            ':uploaded_by' => $data['uploaded_by_user_id']
        ]);

        return $id;
    }

    public function read(string $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_user = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function readAll(): array
    {
        $query = "SELECT g.*, u.username as uploaded_by_username 
                  FROM {$this->table} g
                  LEFT JOIN users u ON g.uploaded_by_user_id = u.id_user
                  ORDER BY g.upload_date DESC";

        return $this->db->query($query)->fetchAll();
    }

    public function update(string $id, array $data): bool
    {
        $query = "UPDATE {$this->table} SET title = :title, description = :description 
                  WHERE id_user = :id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':id' => $id
        ]);
    }

    public function delete(string $id): bool
    {
        $photo = $this->read($id);
        if ($photo && file_exists(PUBLIC_PATH . '/' . $photo['photo_path'])) {
            unlink(PUBLIC_PATH . '/' . $photo['photo_path']);
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_user = :id");
        return $stmt->execute([':id' => $id]);
    }
}
