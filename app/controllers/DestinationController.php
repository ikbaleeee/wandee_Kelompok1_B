<?php
require_once __DIR__ . '/../models/DestinationModel.php';

class DestinationController {
    protected $conn;
    protected $model;

    public function __construct($conn){
        $this->conn = $conn;
        $this->model = new DestinationModel($conn);
    }

    protected function requireAdmin(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin'){
            header('Location: /wandee/auth/loginregister');
            exit;
        }
    }

    protected function redirectBack($location, array $errors = [], array $old = []){
        if(session_status() === PHP_SESSION_NONE) session_start();
        if(!empty($errors)){
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old'] = $old;
        }
        header('Location: ' . $location);
        exit;
    }

    protected function validateImage(array $file, array &$errors){
        if($file['error'] !== UPLOAD_ERR_OK){
            $errors[] = 'Upload gambar gagal. Pastikan file dipilih dengan benar.';
            return false;
        }

        $validExtensions = ['jpg', 'jpeg', 'png'];
        $imageInfo = pathinfo($file['name']);
        $extension = strtolower($imageInfo['extension'] ?? '');

        if(!in_array($extension, $validExtensions, true)){
            $errors[] = 'Format gambar harus JPG, JPEG, atau PNG.';
            return false;
        }

        $allowedMime = ['image/jpeg', 'image/png'];
        $fileMime = mime_content_type($file['tmp_name']);
        if(!in_array($fileMime, $allowedMime, true)){
            $errors[] = 'Format gambar tidak valid. Pilih file JPG / JPEG / PNG.';
            return false;
        }

        if($file['size'] > 5 * 1024 * 1024){
            $errors[] = 'Ukuran gambar maksimal 5 MB.';
            return false;
        }

        return true;
    }

    // expects POST data and FILES for add
    public function add(){
        $this->requireAdmin();

        $title = $_POST['title'] ?? '';
        $location = $_POST['location'] ?? '';
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'] ?? 0;
        $trip_date = trim($_POST['trip_date'] ?? '');
        $quota = $_POST['quota'] ?? '';
        $rating = $_POST['rating'] ?? 5;
        $description = $_POST['description'] ?? '';
        $facilities = trim($_POST['facilities'] ?? '');

        $errors = [];
        $old = [
            'title' => $title,
            'location' => $location,
            'category' => $category,
            'price' => $price,
            'trip_date' => $trip_date,
            'quota' => $quota,
            'rating' => $rating,
            'description' => $description,
            'facilities' => $facilities,
            'itinerary' => $_POST['itinerary'] ?? [],
        ];

        if(empty($title) || empty($location) || empty($category) || $price === '' || empty($trip_date) || $quota === '' || empty($description)){
            $errors[] = 'Nama, lokasi, kategori, harga, tanggal trip, kuota, dan deskripsi wajib diisi.';
        }

        if($price === '' || !is_numeric($price)){
            $errors[] = 'Harga harus berupa angka.';
        }

        if($quota === '' || !ctype_digit((string)$quota) || (int)$quota < 1){
            $errors[] = 'Kuota harus berupa angka minimal 1.';
        }

        if(!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE){
            $errors[] = 'Gambar destinasi wajib diunggah.';
        } elseif(!$this->validateImage($_FILES['image'], $errors)){
            // errors added by validateImage
        }

        if(!empty($errors)){
            $this->redirectBack('/wandee/admin/manage', $errors, $old);
        }

        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $destFolder = __DIR__ . '/../../public/assets/img/';
        if(!is_dir($destFolder)) mkdir($destFolder, 0755, true);
        $image_name = time() . '_' . preg_replace('/[^A-Za-z0-9_\.\-]/', '_', basename($image_name));
        move_uploaded_file($tmp_name, $destFolder . $image_name);

        // Process itinerary
        $itinerary_post = $_POST['itinerary'] ?? [];
        $itinerary_data = [];
        if(is_array($itinerary_post)){
            foreach($itinerary_post as $index => $item){
                if(!empty($item['title']) || !empty($item['desc'])){
                    $itinerary_data[] = [
                        'label' => 'Hari ke-' . ($index + 1),
                        'title' => trim($item['title'] ?? ''),
                        'desc' => trim($item['desc'] ?? ''),
                        'time' => trim($item['time'] ?? '')
                    ];
                }
            }
        }
        $itinerary_json = !empty($itinerary_data) ? json_encode($itinerary_data) : null;

        $this->model->create([
            'title'=>$title,
            'location'=>$location,
            'category'=>$category,
            'price'=>$price,
            'trip_date'=>$trip_date,
            'quota'=>$quota,
            'rating'=>$rating,
            'description'=>$description,
            'image'=>$image_name,
            'itinerary'=>$itinerary_json,
            'facilities'=>$facilities
        ]);

        header('Location: /wandee/admin/manage');
        exit;
    }

    // expects GET id param
    public function delete(){
    $this->requireAdmin();

    $id = $_GET['id'] ?? $_GET['delete'] ?? null;

    if(!$id){
        header('Location: /wandee/admin/manage');
        exit;
    }

    $data = mysqli_query(
        $this->conn,
        "SELECT title FROM destinations WHERE id=" . (int)$id
    );

    $row = mysqli_fetch_assoc($data);
    $namaDestinasi = $row['title'] ?? 'Destinasi';

    $this->model->deleteById($id);

    $_SESSION['success'] =
        '✅ Destinasi "' . $namaDestinasi . '" berhasil dihapus.';

    header('Location: /wandee/admin/manage');
    exit;
}

    public function update(){
        $this->requireAdmin();
        // expects POST with id and optionally FILES['image']
        $id = $_POST['id'] ?? null;
        if(!$id){
            header('Location: /wandee/admin/manage');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $location = $_POST['location'] ?? '';
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'] ?? '';
        $trip_date = trim($_POST['trip_date'] ?? '');
        $quota = $_POST['quota'] ?? '';
        $rating = $_POST['rating'] ?? 0;
        $description = $_POST['description'] ?? '';
        $facilities = trim($_POST['facilities'] ?? '');

        $errors = [];
        $old = [
            'title' => $title,
            'location' => $location,
            'category' => $category,
            'price' => $price,
            'trip_date' => $trip_date,
            'quota' => $quota,
            'rating' => $rating,
            'description' => $description,
            'facilities' => $facilities,
            'itinerary' => $_POST['itinerary'] ?? [],
        ];

        if(empty($title) || empty($location) || empty($category) || $price === '' || empty($trip_date) || $quota === '' || empty($description)){
            $errors[] = 'Nama, lokasi, kategori, harga, tanggal trip, kuota, dan deskripsi wajib diisi.';
        }

        if($price === '' || !is_numeric($price)){
            $errors[] = 'Harga harus berupa angka.';
        }

        if($quota === '' || !ctype_digit((string)$quota) || (int)$quota < 1){
            $errors[] = 'Kuota harus berupa angka minimal 1.';
        }

        // get old record to fallback image
        $res = mysqli_query($this->conn, "SELECT * FROM destinations WHERE id='" . (int)$id . "' LIMIT 1");
        $data = $res ? mysqli_fetch_assoc($res) : [];
        $image = $data['image'] ?? '';

        if(isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE){
            if($this->validateImage($_FILES['image'], $errors)){
                $image = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $destFolder = __DIR__ . '/../../public/assets/img/';
                if(!is_dir($destFolder)) mkdir($destFolder, 0755, true);
                $image = time() . '_' . preg_replace('/[^A-Za-z0-9_\.\-]/', '_', basename($image));
                move_uploaded_file($tmp, $destFolder . $image);
            }
        }

        if(!empty($errors)){
            $this->redirectBack('/wandee/admin/edit_destination?id=' . (int)$id, $errors, $old);
        }

        // Process itinerary
        $itinerary_post = $_POST['itinerary'] ?? [];
        $itinerary_data = [];
        if(is_array($itinerary_post)){
            foreach($itinerary_post as $index => $item){
                if(!empty($item['title']) || !empty($item['desc'])){
                    $itinerary_data[] = [
                        'label' => 'Hari ke-' . ($index + 1),
                        'title' => trim($item['title'] ?? ''),
                        'desc' => trim($item['desc'] ?? ''),
                        'time' => trim($item['time'] ?? '')
                    ];
                }
            }
        }
        $itinerary_json = !empty($itinerary_data) ? json_encode($itinerary_data) : null;

        $this->model->updateById($id, [
            'title'=>$title,
            'location'=>$location,
            'category'=>$category,
            'price'=>$price,
            'trip_date'=>$trip_date,
            'quota'=>$quota,
            'rating'=>$rating,
            'description'=>$description,
            'image'=>$image,
            'itinerary'=>$itinerary_json,
            'facilities'=>$facilities
        ]);

        header('Location: /wandee/admin/manage');
        exit;
    }
}
