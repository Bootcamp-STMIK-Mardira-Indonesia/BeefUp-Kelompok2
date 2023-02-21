<?php

require_once('Database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Header: X-Requested-With');

class Profil
{
    private string $table = 'users';
    private ?string $username;
    private ?string $email;
    public ?int $id;
    private ?object $statement;

    public function __construct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->username = $_POST['username'] ?? null;
        $this->email = $_POST['email'] ?? null;
        $this->id = $_GET['id'] ?? null;
    }

    public function users(): void
    {
        if ($this->id) {
            $user = $this->getUser($this->id);
            $response = [
                'message' =>  'Data User',
                'data' => $user
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            $users = $this->getUsers();
            $total = count($users);
            $response = [
                'message' => 'Data User',
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

    private function getUser(int $id): object
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':user_id', $id);
        $statement->execute();
        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data User Tidak Ditemukan!',
            ];
            http_response_code(404);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }
        $user = $statement->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    
    public function update(int $id): void
    {
        $data = file_get_contents("php://input");
        $_PUT = json_decode($data, true);
        $this->username = $_PUT['username'] ?? null;
        $this->email = $_PUT['email'] ?? null;

        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $statement = $this->statement->prepare($query);
        $statement->bindparam(':user_id', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data User Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        } 

        $query = "UPDATE {$this->table} SET username = :username, email = :email WHERE user_id = :user_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':username', $this->username);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':user_id', $id);
        $statement->execute();
        $response = [
            'message' => 'Data User Berhasil Diubah',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    
}

$profil = new Profil();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $profil->users();
        break;
    case 'PUT':
        $profil->update($profil->id);
        break;
    default:
        $response = [
            'message' => 'Method Not Allowed',
        ];
        http_response_code(405);
        echo json_encode($response);
        break;
}