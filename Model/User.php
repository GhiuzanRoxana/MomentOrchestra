<?php

class User implements CrudInterface
{

    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO {$this->table} (id_user, username, password, email, role, full_name) 
                  VALUES (:id, :username, :password, :email, :role, :full_name)";

        $stmt = $this->db->prepare($query);
        $id = 'USER_' . uniqid();
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->execute([
            ':id' => $id,
            ':username' => $data['username'],
            ':password' => $hashed,
            ':email' => $data['email'],
            ':role' => $data['role'] ?? 'user',
            ':full_name' => $data['full_name']
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
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY username");
        return $stmt->fetchAll();
    }

    public function update(string $id, array $data): bool
    {
        $query = "UPDATE {$this->table} SET username = :username, email = :email, 
                  full_name = :full_name WHERE id_user = :id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':full_name' => $data['full_name'],
            ':id' => $id
        ]);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_user = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_get_info($user['password'])['algo'] === null) {
                if ($password === $user['password']) {
                    return $user;
                }
            } else {
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
        }

        return false;
    }
}
