<?php
require_once '../golbal.php';
require_once '../libs/members.php';
//Nếu đã đăng nhập rồi thì check_session
check_session();
extract($_REQUEST);
if (isset($btnlogin)) {
  if (check_user($username)) {
    //Trong trường hợp username tồn tại thì lấy ra dữ liệu
    $user = check_user($username);
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user;
      if ($_SESSION['user']['role'] == 1000) {
        header('location:' . ROOT . 'admin');
      }
      if ($_SESSION['user']['role'] == 100) {
        header('location:' . ROOT);
      }
    } else {
      $error['password'] = "Mật khẩu không đúng!";
    }
  } else {
    $error['username'] = "Username không đúng";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>PolyBarber - Login</title>

  <!-- Custom fonts for this template-->
  <link href="resource/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="resource/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" placeholder="Username..." name="username">
                      <label for="">
                        <?= isset($error['username']) ? $error['username'] : '' ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                      <label for="">
                        <?= isset($error['password']) ? $error['password'] : '' ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                        <label class="custom-control-label" for="customCheck">Nhớ mật khẩu</label>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" name="btnlogin">Đăng nhập</button>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="resource/vendor/jquery/jquery.min.js"></script>
  <script src="resource/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="resource/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="resource/js/sb-admin-2.js"></script>

</body>

</html>