<?php
include 'config.php';
include 'csrf.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Smart Screenhouse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Login Style -->
    <link href="../assets/css/styleslogin.css" rel="stylesheet">


    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> -->

</head>

<body>

    <div class="login-wrapper">
        <div class="login-box">
            <h3 class="text-center mb-4 fw-bold">Smart Screenhouse</h3>

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
                </div>
            <?php } ?>

            <form action="login_process.php" method="post" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

                <input type="text" name="username" placeholder="Username" required class="form-control-custom mb-3">
                <input type="password" name="password" placeholder="Password" required class="form-control-custom mb-3">
                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>