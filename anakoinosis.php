<?php
$titlos = 'Ανακοινώσεις';
include 'header.php';
$anakoinoseis = anakoinoseis();

?>

<body>
    <?php
    //αν εισήλθε διαχειριστής
    if (isset($_SESSION["user_role"]) and $_SESSION["user_role"] == 1) { ?>
        <div class="text-center">
            <a href="" class="btn btn-primary btn-rounded mb-4" data-toggle="modal" data-target="#modalContactForm">Νέα Ανακοίνωση</a>
        </div>


        <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Νέα Ανακοίνωση</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="insertAn.php" method="post" id="edit-form">
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5">
                                <i class="fas fa-tag prefix grey-text"></i>
                                <input type="text" name="titlos" placeholder="Τίτλος Ανακοίνωσης" class="form-control validate">
                            </div>

                            <div class="md-form modal-dialog-scrollable">
                                <i class="fas fa-pencil prefix grey-text"></i>
                                <textarea type="text" name="keimeno" placeholder="Κείμενο Ανακοίνωσης" class="md-textarea form-control" rows="14"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-primary" type="submit" name="insertdata">Καταχώρηση <i class="fas fa-paper-plane-o ml-1"></i></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    <?php



    } ?>


    <!-- oρισμός μεγεθων & αποστάσεις  -->
    <h1 class="fs-3 ms-4">Ανακοινώσεις</h1>
    <br>
    <div class="container border border-3 overflow-auto vertical-scrollable " style="max-height: 600px">
        <div class="row">
            <?php
            $i = 1;
            $anakoinoseis = array_reverse($anakoinoseis); //οι Τελευταίες ανακοινώσεις θέλουμε να εμφανίζονται πρώτες.
            foreach ($anakoinoseis as $item) : //προσπέλαση των ανακοινώσεων 
            ?>

                <div class="" id="anakoinosi<?php echo $i ?>">
                    <h3 class="fs-4 fw-normal lh-1">* <?php echo hmerominia($item['datenews']);  ?></h3>
                    <h2 class="fs-4 lh-1"><?php echo $item['title'] . " ";
                                            if (isset($_SESSION["user_role"]) and $_SESSION["user_role"] == 1)
                                                echo "<a class='btn btn-danger' href='diagrafi.php?item={$item['idnews']}'>Διαγραφή</a>";
                                            echo "</h2>" //για αισθητικούς λόγους να είναι στην ίδια γραμμή το κουμπί με τον τίτλο
                                            ?>


                        <div class="border border-3">
                            <p class="text-center mt-5 mb-5"><?php echo $item['newstext']; ?></p>
                        </div>
                </div>

            <?php
                // if ($i==3) break; //θέλουμε να εμφανίζονται όλες
                $i++;
            endforeach;
            ?>
        </div>
    </div>

    <!-- oρισμός υποσελίδου  -->

    <?php include 'footer.php'; ?>

    <!-- bootstrap javascript library -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>