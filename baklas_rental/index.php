<?php
require_once 'config.php';

$movies = $conn->query("SELECT * FROM movies");
// var_dump($movies);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Document</title>
    <style>

    </style>
</head>

<body>






    <div class="row m-3">
        <?php
        while ($movie = $movies->fetch_assoc()) {
        ?>
            <div class="card col-md-3 p-3">
                <img src="images/<?= $movie['image']; ?>.jpg" alt="" height="400px" width="300px">
                <div class="col mt-2">
                    <p>Title: <?= $movie['title']; ?></p>
                    <p>Genre: <?= $movie['genre']; ?></p>
                    <p>Actors: <?= $movie['actors']; ?></p>
                    <p>Available for Ren: <?= $movie['available']; ?></p>
                    <button class="form-control btn btn-success reserve" value="<?= $movie['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalId" <?php if ($movie['available'] == 0) echo 'disabled' ?>>Reserve Now!</button>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Modal trigger button -->

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row grid-2">
                        <div class="col">
                            <img src="images/tt1502712.jpg" alt="" height="300px" id="poster">
                        </div>
                        <div class="col">
                            <form action="save.php" method="POST">
                                <label for="name">Fullname:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Input your name..">
                                <label for="contactno">Contact NO.</label>
                                <input type="tel" class="form-control" id="contactno" name="contactno" placeholder="Input your name..">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <input type="hidden" id="movieID" name="movieID">
                                <input type="hidden" id="available" name="available">

                                <button class="form-control" id="submitbtn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script>







    <script src=" jquery-3.6.1.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.reserve').click(function() {
                // alert(this.value);
                var request = $.ajax({
                    url: "modal.php",
                    method: "GET",
                    data: {
                        id: this.value
                    },
                    dataType: "json"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $('#poster').attr('src', './images/' + msg.image + '.jpg');
                    $('#movieID').val(msg.id);
                    // alert(msg.id);
                    $('#available').val(msg.available);

                });



            })




        })
    </script>
</body>

</html>