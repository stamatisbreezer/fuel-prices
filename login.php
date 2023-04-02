<?php
$titlos = 'Είσοδος';
include 'header.php';
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $result = $conn->query("SELECT * FROM user WHERE username = '" . $username . "'");
    $user = $result->fetch_assoc();


    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["iduser"]; //ποιος χρήστης
            $_SESSION["user_role"] = $user["idrole"]; //ιδιότητα χρήστη
            header("Location: kataxorisi.php");
            exit;
        }
    }
    $is_invalid = true;
}
?>

<body>
    <br>
    <!-- oρισμός μεγεθων & αποστάσεις  -->
    <h1 class="fs-3 ms-4">Είσοδος Χρήστη</h1>
    <br>


    <form method="post">
        <div class="form-group row m-2 mt-2">
            <label for="username" class="col-sm-2 col-form-label col-form-label"><strong>Όνομα Χρήστη:</strong></label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control" name="username" id="username" placeholder="username" value="<?php echo htmlspecialchars($_POST["username"] ?? "") ?>">
            </div>

            <label for="password" class="col-sm-2 col-form-label col-form-label"><strong>Κωδικός</strong></label>
            <div class="col-sm-10 mt-2">
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
            </div>
        </div>
        <br>

        <?php
        if ($is_invalid) echo '<p class="badge bg-danger text-wrap fst-italic">Λανθασμένα στοιχεία εισόδου</p>';
        ?>


        <div class="form-group row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-secondary">Είσοδος</button>
            </div>

            <a href="eggrafi.php" class="link-secondary text-center">Εγγραφή νέας Επιχείρησης</a>
        </div>



    </form>


    <!-- oρισμός υποσελίδου  -->

    <?php include 'footer.php'; ?>

</body>

</html>