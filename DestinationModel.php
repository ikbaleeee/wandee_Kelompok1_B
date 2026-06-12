<?php
class DestinationModel {
    protected $conn;
    protected $columns = [];

    public function __construct($conn){
        $this->conn = $conn;
    }

    protected function columnExists($column){
        if(isset($this->columns[$column])){
            return $this->columns[$column];
        }

        $column = mysqli_real_escape_string($this->conn, $column);
        $res = mysqli_query($this->conn, "SHOW COLUMNS FROM destinations LIKE '$column'");
        $this->columns[$column] = $res && mysqli_num_rows($res) > 0;
        return $this->columns[$column];
    }

    public function getAllOrderedByRating(){
        $res = mysqli_query($this->conn, "SELECT * FROM destinations ORDER BY rating DESC");
        $data = [];
        if($res){
            while($row = mysqli_fetch_assoc($res)){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAllOrderedById(){
        $res = mysqli_query($this->conn, "SELECT * FROM destinations ORDER BY id DESC");
        $data = [];
        if($res){
            while($row = mysqli_fetch_assoc($res)){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function findById($id){
        $id = (int)$id;
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM destinations WHERE id = ?");
        if(!$stmt){
            return null;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result ? mysqli_fetch_assoc($result) : null;
    }

    public function create($data){
        $title = mysqli_real_escape_string($this->conn, $data['title']);
        $location = mysqli_real_escape_string($this->conn, $data['location']);
        $category = mysqli_real_escape_string($this->conn, $data['category']);
        $price = mysqli_real_escape_string($this->conn, $data['price']);
        $rating = mysqli_real_escape_string($this->conn, $data['rating']);
        $description = mysqli_real_escape_string($this->conn, $data['description']);
        $image = mysqli_real_escape_string($this->conn, $data['image']);

        $fields = ['title', 'location', 'category', 'price', 'rating', 'description', 'image'];
        $values = ["'$title'", "'$location'", "'$category'", "'$price'", "'$rating'", "'$description'", "'$image'"];

        if($this->columnExists('trip_date')){
            $trip_date = mysqli_real_escape_string($this->conn, $data['trip_date'] ?? '');
            $fields[] = 'trip_date';
            $values[] = "'$trip_date'";
        }

        if($this->columnExists('quota')){
            $quota = (int)($data['quota'] ?? 0);
            $fields[] = 'quota';
            $values[] = "'$quota'";
        }

        if($this->columnExists('itinerary')){
            $itinerary = mysqli_real_escape_string($this->conn, $data['itinerary'] ?? '');
            $fields[] = 'itinerary';
            $values[] = "'$itinerary'";
        }

        if($this->columnExists('facilities')){
            $facilities = mysqli_real_escape_string($this->conn, $data['facilities'] ?? '');
            $fields[] = 'facilities';
            $values[] = "'$facilities'";
        }

        $query = "INSERT INTO destinations (" . implode(', ', $fields) . ")
            VALUES (" . implode(', ', $values) . ")";

        return mysqli_query($this->conn, $query);
    }

    public function deleteById($id){
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM destinations WHERE id='$id'");
    }

    public function updateById($id, $data){
        $id = (int)$id;
        $title = mysqli_real_escape_string($this->conn, $data['title']);
        $location = mysqli_real_escape_string($this->conn, $data['location']);
        $category = mysqli_real_escape_string($this->conn, $data['category']);
        $price = mysqli_real_escape_string($this->conn, $data['price']);
        $rating = mysqli_real_escape_string($this->conn, $data['rating']);
        $description = mysqli_real_escape_string($this->conn, $data['description']);
        $image = mysqli_real_escape_string($this->conn, $data['image']);

        $updates = [
            "title='$title'",
            "location='$location'",
            "category='$category'",
            "price='$price'",
            "rating='$rating'",
            "description='$description'",
            "image='$image'"
        ];

        if($this->columnExists('trip_date')){
            $trip_date = mysqli_real_escape_string($this->conn, $data['trip_date'] ?? '');
            $updates[] = "trip_date='$trip_date'";
        }

        if($this->columnExists('quota')){
            $quota = (int)($data['quota'] ?? 0);
            $updates[] = "quota='$quota'";
        }

        if($this->columnExists('itinerary')){
            $itinerary = mysqli_real_escape_string($this->conn, $data['itinerary'] ?? '');
            $updates[] = "itinerary='$itinerary'";
        }

        if($this->columnExists('facilities')){
            $facilities = mysqli_real_escape_string($this->conn, $data['facilities'] ?? '');
            $updates[] = "facilities='$facilities'";
        }

        $query = "UPDATE destinations SET " . implode(', ', $updates) . " WHERE id='$id'";

        return mysqli_query($this->conn, $query);
    }

    public function updateRating($id, $rating){
        $id = (int)$id;
        $rating = mysqli_real_escape_string($this->conn, number_format((float)$rating, 1, '.', ''));
        return mysqli_query($this->conn, "UPDATE destinations SET rating='$rating' WHERE id='$id'");
    }

    public function decreaseQuota($id, $amount){
        $id = (int)$id;
        $amount = (int)$amount;
        return mysqli_query($this->conn, "UPDATE destinations SET quota = GREATEST(0, quota - $amount) WHERE id = '$id'");
    }

    public function increaseQuota($id, $amount){
        $id = (int)$id;
        $amount = (int)$amount;
        return mysqli_query($this->conn, "UPDATE destinations SET quota = quota + $amount WHERE id = '$id'");
    }
}
