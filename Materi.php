<?php

require_once('Database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Header: X-Requested-With');

class Materi
{
    private string $table = 'materi';
    private ?string $judul;
    private ?string $isi;
    private ?string $ringkasan;
    public ?int $id;
    private ?object $statement;

    public function __construct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->judul = $_POST['judul'] ?? null;
        $this->isi = $_POST['isi'] ?? null;
        $this->ringkasan = $_POST['ringkasan'] ?? null;
        $this->id = $_GET['id'] ?? null;
    }

    public function materi(): void
    {
        if ($this->id) {
            $materis = $this->getMateri($this->id);
            $response = [
                'message' =>  'Data materi',
                'data' => $materi
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            $materis = $this->getMateris();
            $total = count($materis);
            $response = [
                'message' => 'Data Materi',
                'total' => $total,
                'data' => $materis
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }

    private function getMateris(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        $materis = $statement->fetchAll(PDO::FETCH_OBJ);
        return $materis;
    }

    private function getMateri(int $id): object
    {
        $query = "SELECT * FROM {$this->table} WHERE materi_id = :materi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':materi_id', $id);
        $statement->execute();
        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data Materi Tidak Ditemukan!',
            ];
            http_response_code(404);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }
        $materi = $statement->fetch(PDO::FETCH_OBJ);
        return $materi;
    }

    public function store(): void
    {
        $query = "SELECT * FROM $this->table WHERE judul = :judul";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':judul', $this->judul);
        // $statement->bindParam(':isi', $this->isi);
        // $statement->bindParam(':ringkasan', $this->ringkasan);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $response = [
                'message' => 'Data Materi Sudah Tersedia!',
            ];
            http_response_code(409);
        } else {
            $query = "INSERT INTO {$this->table} (judul, isi, ringkasan) VALUES (:judul, :isi, :ringkasan)";
            $statement = $this->statement->prepare($query);
            $statement->bindparam(':judul', $this->judul);
            $statement->bindParam(':isi', $this->isi);
            $statement->bindparam(':ringkasan',$this-> ringkasan);
            $statement->execute();
            $getMateri = "SELECT * FROM materi WHERE judul = :judul";
            $statement = $this->statement->prepare($getMateri);
            $statement->bindParam(':judul', $this->judul);
            $statement->execute();
            $materis = $statement->fetchAll(PDO::FETCH_OBJ);
            $response = [
                'message' => 'Data Materi Berhasil Ditampilkan',
                'data' => $materis
            ];
            http_response_code(201);
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function update(int $id): void
    {
        $data = file_get_contents("php://input");
        $_PUT = json_decode($data, true);
        $this->judul = $_PUT['judul'] ?? null;
        $this->isi = $_PUT['isi'] ?? null;
        $this->ringkasan = $_PUT['ringkasan'] ?? null;

        $query = "SELECT * FROM {$this->table} WHERE materi_id = :materi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindparam(':materi_id', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data Materi Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        } 

        $query = "UPDATE {$this->table} SET judul = :judul, isi = :isi, ringkasan = :ringkasan WHERE materi_id = :materi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':judul', $this->judul);
        $statement->bindParam(':isi', $this->isi);
        $statement->bindParam(':ringkasan', $this->ringkasan);
        $statement->bindParam(':materi_id', $id);
        $statement->execute();
        $response = [
            'message' => 'Data Materi Berhasil Diubah',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function delete(int $id): void
    {
        $query = "SELECT * FROM {$this->table} WHERE materi_id = :materi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':materi_id', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data Materi Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $query = "DELETE FROM {$this->table} WHERE materi_id = :materi_id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':materi_id', $id);
        $statement->execute();
        $response = [
            'message' => 'Data Materi Berhasil Dihapus',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}

$materis = new Materi();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $materis->materi();
        break;
    case 'POST':
        $materis->store();
        break;
    case 'PUT':
        $materis->update($materis->id);
        break;
    case 'DELETE':
        $materis->delete($materis->id);
        break;
    default:
        $response = [
            'message' => 'Method Not Allowed',
        ];
        http_response_code(405);
        echo json_encode($response);
        break;
}