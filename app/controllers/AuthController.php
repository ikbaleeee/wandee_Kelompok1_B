<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {
    protected $conn;
    protected $userModel;

    public function __construct($conn){
        $this->conn = $conn;
        $this->userModel = new UserModel($conn);
    }

    public function register(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = md5($_POST['password'] ?? '');

        if($this->userModel->findByEmail($email)){
            echo "Email sudah digunakan";
            exit;
        }

        $this->userModel->create($name, $email, $password);
        header("Location: /wandee/auth/loginregister");
        exit;
    }

    public function index(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        require __DIR__ . '/../views/auth.php';
    }

    public function login(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        $email = $_POST['email'] ?? '';
        $password = md5($_POST['password'] ?? '');

        $user = $this->userModel->findByEmail($email);

        if($user && $user['password'] === $password){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // SESSION ACTIVITY
            $_SESSION['last_activity'] = time();

            if($user['role'] == 'admin'){
                header("Location: /wandee/admin/dashboard");
                exit;
            } else {
                header("Location: /wandee/user/index");
                exit;
            }
        } else {
            header("Location: /wandee/auth/loginregister?error=credentials");
            exit;
        }
    }

    public function reset_password(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if(empty($email) || empty($password)){
            header("Location: /wandee/auth/loginregister?error=reset_empty");
            exit;
        }

        if($password !== $confirm_password){
            header("Location: /wandee/auth/loginregister?error=reset_mismatch");
            exit;
        }

        $user = $this->userModel->findByEmail($email);
        if(!$user){
            header("Location: /wandee/auth/loginregister?error=reset_email_not_found");
            exit;
        }

        $password_md5 = md5($password);
        $this->userModel->updatePasswordByEmail($email, $password_md5);

        header("Location: /wandee/auth/loginregister?reset_success=1");
        exit;
    }

    public function logout(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        // clear all session variables
        $_SESSION = [];

        // delete session cookie if used
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }

        // destroy session
        session_unset();
        session_destroy();

        // redirect to landing page
        header("Location: /wandee");
        exit;
    }

    public function google(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        $config = require __DIR__ . '/../../config/oauth.php';

        if ($config['demo_mode']) {
            header("Location: /wandee/auth/google_callback?code=mock_google_code_123");
            exit;
        }

        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth_state'] = $state;

        $params = [
            'client_id' => $config['google']['client_id'],
            'redirect_uri' => $config['google']['redirect_uri'],
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        header("Location: " . $authUrl);
        exit;
    }

    public function google_callback(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        $config = require __DIR__ . '/../../config/oauth.php';

        $code = $_GET['code'] ?? '';
        
        $email = '';
        $name = '';
        $uid = '';
        $provider = 'google';

        if ($config['demo_mode'] || $code === 'mock_google_code_123') {
            $email = 'mock.google.user@example.com';
            $name = 'Google Test User';
            $uid = 'google_mock_123456789';
        } else {
            if (empty($code)) {
                header("Location: /wandee/auth/loginregister?error=google_auth_failed");
                exit;
            }

            // Exchange code for token
            $tokenUrl = 'https://oauth2.googleapis.com/token';
            $tokenData = [
                'code' => $code,
                'client_id' => $config['google']['client_id'],
                'client_secret' => $config['google']['client_secret'],
                'redirect_uri' => $config['google']['redirect_uri'],
                'grant_type' => 'authorization_code'
            ];

            $tokenResponse = $this->httpPost($tokenUrl, $tokenData);
            $tokenJson = json_decode($tokenResponse, true);

            if (empty($tokenJson['access_token'])) {
                header("Location: /wandee/auth/loginregister?error=google_token_failed");
                exit;
            }

            // Fetch user info
            $userInfoUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';
            $userInfoResponse = $this->httpGet($userInfoUrl, ['Authorization: Bearer ' . $tokenJson['access_token']]);
            $userInfoJson = json_decode($userInfoResponse, true);

            if (empty($userInfoJson['sub'])) {
                header("Location: /wandee/auth/loginregister?error=google_user_failed");
                exit;
            }

            $email = $userInfoJson['email'] ?? '';
            $name = $userInfoJson['name'] ?? $userInfoJson['given_name'] ?? 'Google User';
            $uid = $userInfoJson['sub'];
        }

        // Process Database Login/Register
        $user = $this->userModel->findByOAuth($provider, $uid);

        if (!$user) {
            // Check if email already exists to link accounts
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $this->userModel->updateOAuth($existingUser['id'], $provider, $uid);
                $user = $this->userModel->findById($existingUser['id']);
            } else {
                $newId = $this->userModel->createOAuth($name, $email, $provider, $uid);
                $user = $this->userModel->findById($newId);
            }
        }

        // Start session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_activity'] = time();

        if ($user['role'] === 'admin') {
            header("Location: /wandee/admin/dashboard");
        } else {
            header("Location: /wandee/user/index");
        }
        exit;
    }



    private function httpPost($url, $data, $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function httpGet($url, $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
