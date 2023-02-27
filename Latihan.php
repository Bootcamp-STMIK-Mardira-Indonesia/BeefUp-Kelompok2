<?php

require_once('Database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Header: X-Requested-With');

class Latihan
{
    private string $table = 'latihan';
    private ?string $title;
    private ?string $question;
    private ?string $option1;
    private ?string $option2;
    private ?string $option3;
    private ?string $option4;
    private ?string $answer;
    public ?int $id;
    private ?object $statement;

    public function __construct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->title = $_POST['title'] ?? null;
        $this->question = $_POST['question'] ?? null;
        $this->option1 = $_POST['option1'] ?? null;
        $this->option2 = $_POST['option2'] ?? null;
        $this->option3 = $_POST['option3'] ?? null;
        $this->option4 = $_POST['option4'] ?? null;
        $this->answer = $_POST['answer'] ?? null;
        $this->id = $_GET['id'] ?? null;
    }

    public function tampilLatihan(): void
    {
        $query = "SELECT * FROM $this->table";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        $soal = $statement->fetchAll(PDO::FETCH_OBJ);
        $response = [
            'message' => 'Soal Berhasil Ditampilkan!',
            'data' => $soal
        ];
        echo json_encode($response);
    }

    public function tambahLatihan(): void
    {
        $query = "SELECT * FROM $this->table WHERE question = :question";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':question', $this->question);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $response = [
                'message' => 'Soal Sudah Ada!',
            ];
            http_response_code(409);
        } else {
            $query = "INSERT INTO {$this->table} (title, question, option1, option2, option3, option4, answer) VALUES (:title, :question, :option1, :option2, :option3, :option4, :answer)";
            $statement = $this->statement->prepare($query);
            $statement->bindparam(':title', $this->title);
            $statement->bindParam(':question', $this->question);
            $statement->bindparam(':option1', $this->option1);
            $statement->bindparam(':option2', $this->option2);
            $statement->bindparam(':option3', $this->option3);
            $statement->bindparam(':option4', $this->option4);
            $statement->bindparam(':answer', $this->answer);
            $statement->execute();

            $getUsers = "SELECT * FROM latihan WHERE title = :title";
            $statement = $this->statement->prepare($getUsers);
            $statement->bindParam(':title', $this->title);
            $statement->execute();
            $soal = $statement->fetchAll(PDO::FETCH_OBJ);
            $response = [
                'message' => 'Soal Berhasil Ditambahkan!',
                'data' => $soal
            ];
            http_response_code(201);
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function ubahLatihan($id): void
    {
        $data = file_get_contents("php://input");
        $_PUT = json_decode($data, true);
        $this->title = $_PUT['title'] ?? null;
        $this->question = $_PUT['question'] ?? null;
        $this->option1 = $_PUT['option1'] ?? null;
        $this->option2 = $_PUT['option2'] ?? null;
        $this->option3 = $_PUT['option3'] ?? null;
        $this->option4 = $_PUT['option4'] ?? null;
        $this->answer = $_PUT['answer'] ?? null;

        $query = "SELECT * FROM {$this->table} WHERE id_soal = :id_soal";
        $statement = $this->statement->prepare($query);
        $statement->bindparam(':id_soal', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Data Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        } 

        $query = "UPDATE {$this->table} SET title = :title, question = :question, option1 = :option1, option2 = :option2, option3 = :option3, option4 = :option4, answer = :answer WHERE id_soal = :id_soal";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':question', $this->question);
        $statement->bindParam(':option1', $this->option1);
        $statement->bindParam(':option2', $this->option2);
        $statement->bindParam(':option3', $this->option3);
        $statement->bindParam(':option4', $this->option4);
        $statement->bindParam(':answer', $this->answer);
        $statement->bindParam(':id_soal', $id);
        $statement->execute();
        $response = [
            'message' => 'Soal Berhasil Diubah',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function hapusLatihan(int $id): void
    {
        $query = "SELECT * FROM {$this->table} WHERE id_soal = :id_soal";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':id_soal', $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $response = [
                'message' => 'Soal Tidak Ditemukan!',
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $query = "DELETE FROM {$this->table} WHERE id_soal = :id_soal";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':id_soal', $id);
        $statement->execute();
        $response = [
            'message' => 'Soal Berhasil Dihapus',
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}

$latihan = new Latihan();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $latihan->tampilLatihan();
        break;
    case 'POST':
        $latihan->tambahLatihan();
        break;
    case 'PUT':
        $latihan->ubahLatihan($latihan->id);
        break;
    case 'DELETE':
        $latihan->hapusLatihan($latihan->id);
        break;
    default:
        $response = [
            'message' => 'Method Not Allowed',
        ];
        http_response_code(405);
        echo json_encode($response);
        break;
}