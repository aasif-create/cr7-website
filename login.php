<?php
session_start();
$host = '127.0.0.1';
$db = 'login_db';
$dbuser = 'root';
$dbpass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try{
  $pdo = new PDO($dsn,$dbuser,$dbpass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
}catch(Exception $e){
  echo "<h2 style='color:red;text-align:center;margin-top:40px;'>Database connection error</h2>";
  exit;
}
$user = isset($_POST['username']) ? trim($_POST['username']) : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
if($user === '' || $pass === ''){
  echo "<h2 style='color:red;text-align:center;margin-top:40px;'>Please enter username and password</h2>";
  exit;
}
$stmt = $pdo->prepare("SELECT id,username,password_hash FROM users WHERE username = ? LIMIT 1");
$stmt->execute([$user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$success = 0;
function maskp($p){ $l = strlen($p); if($l<=2) return str_repeat('*',$l); return substr($p,0,1).str_repeat('*',max(1,$l-2)).substr($p,-1); }
if($row && password_verify($pass,$row['password_hash'])){
  $success = 1;
  $_SESSION['username'] = $row['username'];
  $ins = $pdo->prepare("INSERT INTO logins (username,password_masked,ip,success,user_agent) VALUES (?,?,?,?,?)");
  $ins->execute([$user,maskp($pass),$ip,$success,$ua]);
  echo "<!doctype html><html><head><meta charset='utf-8'><title>Welcome</title><meta name='viewport' content='width=device-width,initial-scale=1'></head><body style='font-family:Inter,Arial;text-align:center;padding-top:80px;background:linear-gradient(180deg,#071130,#021026);color:#e6f0ff;'><div style='display:inline-block;background:rgba(255,255,255,0.03);padding:28px;border-radius:12px;box-shadow:0 12px 40px rgba(2,6,23,0.7);'><h1 style='color:#7fffd4;margin-bottom:8px;'>Login Successful!</h1><p style='font-weight:700;font-size:18px;'>Welcome, ".htmlspecialchars($row['username'])."</p><p style='margin-top:12px;'><a href='index.html' style='color:#ffd28a;text-decoration:none;font-weight:700;'>Back to Login</a></p></div></body></html>";
  exit;
}else{
  $ins = $pdo->prepare("INSERT INTO logins (username,password_masked,ip,success,user_agent) VALUES (?,?,?,?,?)");
  $ins->execute([$user,maskp($pass),$ip,0,$ua]);
  echo "<h2 style='color:#ff6b6b;text-align:center;margin-top:40px;'>Invalid Login</h2><p style='text-align:center;margin-top:12px;'><a href='index.html' style='color:#ffd28a;text-decoration:none;'>Try again</a></p>";
  exit;
}
?>
