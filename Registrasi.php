<?php

require_once('Database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Header: X-Requested-With');

class Registrasi
{
    private string $table = 'users';
    private ?string $username;
    private ?string $email;
    private ?string $password;
    private ?int $roleId=2;
    public ?int $id;
    private ?object $statement;

    public function __construct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->username = $_POST['username'] ?? null;
        $this->email = $_POST['email'] ?? null;
        $this->password = $_POST['password'] ?? null;
        $this->roleId = $_POST['roleId'] ?? null; 
        $this->id = $_GET['id'] ?? null;
    }

    public function users(): void
    {
        if ($this->id) {
            $user = $this->getUser($this->id);
            $response = [
                'message' =>  'Data Pengguna',
                'data' => $user
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            $users = $this->getUsers();
            $total = count($users);
            $response = [
                'message' => 'Data Pengguna',
                'total' => $total,
                'data' => $users
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }

    private function getUsers(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_OBJ);
        return $users;
    }

    // private function getUser(int $id): object
    // {
    //     $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
    //     $statement = $this->statement->prepare($query);
    //     $statement->bindParam(':user_id', $id);
    //     $statement->execute();
    //     if ($statement->rowCount() == 0) {
    //         $response = [
    //             'message' => 'Data Pengguna Tidak Ditemukan!',
    //         ];
    //         http_response_code(404);
    //         echo json_encode($response, JSON_PRETTY_PRINT);
    //         exit;
    //     }
    //     $user = $statement->fetch(PDO::FETCH_OBJ);
    //     return $user;
    // }

    public function store(): void
    {
        $query = "SELECT * FROM $this->table WHERE username = :username";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':username', $this->username);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $response = [
                'message' => 'Nama Pengguna Sudah Terdaftar!',
            ];
            http_response_code(409);
        } else {
            $query = "INSERT INTO {$this->table} (username, email, password, roleId) VALUES (:username, :email, :password, :roleId)";
            $statement = $this->statement->prepare($query);
            $password = md5($this->password);
            $roleId = 2;
            $statement->bindparam(':username', $this->username);
            $statement->bindParam(':email', $this->email);
            $statement->bindparam(':password', $password);
            $statement->bindParam(':roleId', $roleId);
            $statement->execute();
            $getUsers = "SELECT * FROM users WHERE username = :username";
            $statement = $this->statement->prepare($getUsers);
            $statement->bindParam(':username', $this->username);
            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_OBJ);
            $response = [
                'message' => 'Data Pengguna Berhasil Ditampilkan',
                'data' => $users
            ];
            http_response_code(201);
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    
}

$registrasi = new Registrasi();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $registrasi->users();
        break;
    case 'POST':
        $registrasi->store();
        break;
    default:
        $response = [
            'message' => 'Method Not Allowed',
        ];
        http_response_code(405);
        echo json_encode($response);
        break;
}