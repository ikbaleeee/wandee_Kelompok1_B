<?php
class UserModel {
    protected $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function findByEmail($email){
        $email = mysqli_real_escape_string($this->conn, $email);
        $res = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    public function findById($id){
        $id = (int)$id;
        $res = mysqli_query($this->conn, "SELECT * FROM users WHERE id='$id' LIMIT 1");
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    public function updateWithPassword($id, $name, $email, $password, $photo){
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        $photo = mysqli_real_escape_string($this->conn, $photo);
        return mysqli_query($this->conn, "UPDATE users SET name='$name', email='$email', password='$password', photo='$photo' WHERE id='$id'");
    }

    public function updateWithoutPassword($id, $name, $email, $photo){
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $photo = mysqli_real_escape_string($this->conn, $photo);
        return mysqli_query($this->conn, "UPDATE users SET name='$name', email='$email', photo='$photo' WHERE id='$id'");
    }

    public function updatePasswordByEmail($email, $password){
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        return mysqli_query($this->conn, "UPDATE users SET password='$password' WHERE email='$email'");
    }

    public function create($name, $email, $password){
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        mysqli_query($this->conn, "INSERT INTO users(name,email,password) VALUES('$name','$email','$password')");
        return mysqli_insert_id($this->conn);
    }

    public function countAll(){
        $res = mysqli_query($this->conn, "SELECT id FROM users");
        return $res ? mysqli_num_rows($res) : 0;
    }

    public function countFavorites($user_id){
        $user_id = (int)$user_id;
        $res = mysqli_query($this->conn, "SELECT id FROM favorites WHERE user_id='$user_id'");
        return $res ? mysqli_num_rows($res) : 0;
    }

    public function countBookings($user_id){
        $user_id = (int)$user_id;
        $res = mysqli_query($this->conn, "SELECT id FROM bookings WHERE user_id='$user_id'");
        return $res ? mysqli_num_rows($res) : 0;
    }

    public function countReviews($user_id){
        $user_id = (int)$user_id;
        $res = mysqli_query($this->conn, "SELECT id FROM reviews WHERE user_id='$user_id'");
        return $res ? mysqli_num_rows($res) : 0;
    }

    public function findByOAuth($provider, $uid){
        $provider = mysqli_real_escape_string($this->conn, $provider);
        $uid = mysqli_real_escape_string($this->conn, $uid);
        $res = mysqli_query($this->conn, "SELECT * FROM users WHERE oauth_provider='$provider' AND oauth_uid='$uid' LIMIT 1");
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    public function createOAuth($name, $email, $provider, $uid){
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $provider = mysqli_real_escape_string($this->conn, $provider);
        $uid = mysqli_real_escape_string($this->conn, $uid);
        mysqli_query($this->conn, "INSERT INTO users(name, email, oauth_provider, oauth_uid, role) VALUES('$name', '$email', '$provider', '$uid', 'user')");
        return mysqli_insert_id($this->conn);
    }

    public function updateOAuth($id, $provider, $uid){
        $id = (int)$id;
        $provider = mysqli_real_escape_string($this->conn, $provider);
        $uid = mysqli_real_escape_string($this->conn, $uid);
        return mysqli_query($this->conn, "UPDATE users SET oauth_provider='$provider', oauth_uid='$uid' WHERE id='$id'");
    }
}
