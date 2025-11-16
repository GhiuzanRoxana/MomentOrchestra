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
                  VALUES (:id_user, :path, :title, :description, CURRENT_TIMESTAMP, :uploaded_by)";

        $stmt = $this->db->prepare($query);
        $photoPath = $data['photo_path'];

        $stmt->execute([
            ':id_user' => $data['uploaded_by_user_id'],
            ':path' => $photoPath,
            ':title' => $data['title'],
            ':description' => $data['description'] ?? '',
            ':uploaded_by' => $data['uploaded_by_user_id']
        ]);

        return $data['uploaded_by_user_id'] . '_' . basename($photoPath);
    }

    public function read(string $id)
    {
        $parts = explode('_', $id, 2);
        if (count($parts) !== 2) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_user = :id_user AND photo_path LIKE :path");
        $stmt->execute([
            ':id_user' => $parts[0],
            ':path' => '%' . $parts[1] . '%'
        ]);
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
        $parts = explode('_', $id, 2);
        if (count($parts) !== 2) {
            return false;
        }

        $query = "UPDATE {$this->table} SET title = :title, description = :description 
                  WHERE id_user = :id_user AND photo_path LIKE :path";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':id_user' => $parts[0],
            ':path' => '%' . $parts[1] . '%'
        ]);
    }

    public function delete(string $id): bool
    {
        $photo = $this->read($id);
        if ($photo && file_exists(PUBLIC_PATH . '/' . $photo['photo_path'])) {
            unlink(PUBLIC_PATH . '/' . $photo['photo_path']);
        }

        $parts = explode('_', $id, 2);
        if (count($parts) !== 2) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_user = :id_user AND photo_path LIKE :path");
        return $stmt->execute([
            ':id_user' => $parts[0],
            ':path' => '%' . $parts[1] . '%'
        ]);
    }
}
