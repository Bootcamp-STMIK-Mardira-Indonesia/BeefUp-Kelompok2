<?php

require_once('Database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Header: X-Requested-With');

class Testimoni
{
    private string $table = 'testimoni';
    private ?string $username;
    private ?string $testimoni;
    public ?int $id;
    private ?object $statement;

    public function __construct() 
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->username = $_POST['username'] ?? null;
        $this->testimoni = $_POST['testimoni'] ?? null;
        $this->id = $_GET['id'] ?? null;
    }

    public function tampilTestimoni(): void
    {
        $query = "SELECT * FROM $this->table";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        $testimoni = $statement->fetchAll(PDO::FETCH_OBJ);
        $response = [
            'message' => 'Testimoni Berhasil Ditampilkan!',
            'data' => $testimoni
        ];
        echo json_encode($response);
    }

    public function simpanTestimoni(): void
    {
        $query = "INSERT INTO {$this->table} (username, testimoni) VALUES (:username, :testimoni)";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':username', $this->username);
        $statement->bindParam(':testimoni', $this->testimoni);
        $statement->execute();
        $testimoni = $statement->fetchAll(PDO::FETCH_OBJ);
        $response = [
            'message' => 'Testimoni Berhasil Ditambahkan!',
            'data' => $testimoni
        ];
        http_response_code(201);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function hapusTestimoni(int $id): void
    {
        $query = "SELECT * FROM {$this->table} WHERE testi_id = :testi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':testi_id', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Testimoni Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $query = "DELETE FROM {$this->table} WHERE testi_id = :testi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':testi_id', $id);
        $statement->execute();
        $response = [
            'message' => 'Testimoni Berhasil Dihapus',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}

$testimoni = new Testimoni();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $testimoni->tampilTestimoni();
        break;
    case 'POST':
        $testimoni->simpanTestimoni();
        break;
    case 'DELETE':
        $testimoni->hapusTestimoni($testimoni->id);
        break;
    default:
        $response = [
            'message' => 'Method Not Allowed',
        ];
        http_response_code(405);
        echo json_encode($response);
        break;
}