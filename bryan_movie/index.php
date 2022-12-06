<?php
require_once 'config.php';
$movies = $qq->query("SELECT * FROM movies ORDER BY title");
// var_dump($movies);
$movieArr = array();
// $duration = $_GET['duration'];
while ($movie = $movies->fetch_assoc()) {
    array_push($movieArr, $movie);
}
$players = $qq->query("SELECT * FROM players Order by score DESC, duration LIMIT 10");
// var_dump($movieArr);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Movie Baklas</title>
</head>

<body>
    <div class="container">
        <div class="d-flex row justify-object-center align-items-center" style="height: 550px;" id="mainUi">
            <div class="col-md-6 m-auto shadow-lg">
                <h1 class="text-center">Movie Quiz</h1>
                <input type="text" class="form-control" name="player_name" id="player_name" placeholder="Please input your name...." required>
                <div class="col-sm-5 m-auto">
                    <button class="form-control bg-success mt-2 mb-2" id="start">Ready</button>
                </div>

            </div>
            <div class="col-md-6">
                <table class="col-3 table table-striped-columns m-auto mt-5" id="table">
                    <thead>
                        <tr>
                            <th class="bg-dark text-light" colspan="4">Leader Board</th>
                        </tr>
                        <tr class="text-center">
                            <th>Date</th>
                            <th>Name</th>
                            <th>Score</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($player = $players->fetch_assoc()) {
                        ?>
                            <tr class="text-center">
                                <td><?php echo $player['dateStart'] ?></td>
                                <td><?php echo $player['player_name'] ?></td>
                                <td><?php echo $player['score'] ?></td>
                                <td><?php echo $player['duration'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container d-none" id="quizUi">
            <div class="col-md-4 m-auto text-center mt-1">
                <h4>SCORE <span class="score">0</span></h4>
            </div>
            <div class="card col-md-5 m-auto text-center shadow-lg">
                <img class="card-body img-fluid m-auto" src="./images/tt0369610.jpg" alt="" width="300px" id="image">
            </div>
            <div class="row m-auto text-center">
                <div class="col-md-6">
                    <button class="btn btn-dark py-3 form-control mt-3 choice" id="a">Choice A</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-dark py-3 form-control mt-3 choice" id="b">Choice B</button>
                </div>
            </div>
            <div class="row m-auto text-center mb-2">
                <div class="col-md-6">
                    <button class="btn btn-dark py-3 form-control mt-3 choice" id="c">Choice C</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-dark py-3 form-control mt-3 choice" id="d">Choice D</button>
                </div>
            </div>
        </div>


    </div>

    <!-- .
    <!-- Modal trigger button -->
    <!-- . -->
    <!-- Modal trigger button -->
    <button type="button" class="btn btn-primary btn-lg d-none" data-bs-toggle="modal" data-bs-target="#modalId" id="btn">
        Launch
    </button>

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="form-control bg-dark text-light" disabled>Your Score is <span class="score"></span>/10</button>
                    <button class="form-control bg-dark text-light" disabled id="modalDuration"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="playb">Play Again</button>
                    <!-- <button type="button" class="btn btn-primary">Save</button> -->
                </div>
            </div>
        </div>
    </div>


    <!-- Optional: Place to the bottom of scripts -->
    <!-- <script>
        const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script> -->


    <script src="bootstrap.bundle.min.js"></script>
    <script src="jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let movieArr = <?php echo json_encode($movieArr); ?>;
            // console.log(movieArr);
            let dateStart = null;
            let dateEnd = null;
            let Pointer = 0;
            let questionBank = [];
            let nextpointer = 0;
            let score = 0;

            movieArr.sort((a, b) => .5 - Math.random());

            $('#leaderB').click(function() {
                $('#table').addClass('d-none');
                $('#table').removeClass('d-none');
            })
            // let player = $('#player_name').val();

            $('#start').click(function() {
                let player_name = $('#player_name').val();
                if (player_name.length == 0) {
                    alert('hahahahahaha');
                } else {
                    $('#mainUi').addClass('d-none');
                    $('#quizUi').removeClass('d-none');
                    // console.log(dateStart);
                    dateStart = Date.now();
                    // alert(player_name);\
                    var request = $.ajax({
                        url: "save.php",
                        method: "POST",
                        data: {
                            player_name: player_name
                        },
                        dataType: "html"
                    });

                }
                // if (player_name == player_name) {
                //     alert("23123");
                // }
                // request.done(function(msg) {
                //     alert(msg);
                // })
            })

            // console.log(movieArr);

            class Question {
                constructor(poster, answer, choices) {
                    this.poster = poster;
                    this.answer = answer;
                    this.choices = choices.sort((a, b) => .5 - Math.random());
                }
            }
            loop();

            $('.choice').click(function() {
                // alert('hellow');
                // console.log(this.value);
                if (this.value == questionBank[Pointer].answer) {
                    // alert('tama ka');
                    score++;
                    $('.score').html(score);

                } else {

                }
                Pointer++;
                // console.log(Question);
                lastmess();

                updateUI(Pointer);
            })




            function lastmess() {
                if (Pointer == questionBank.length) {
                    $('#btn').click();
                    dateEnd = Date.now();
                    // console.log(dateEnd);
                    let duration = Math.floor((dateEnd - dateStart) / 1000);
                    console.log(duration);
                    $("#modalDuration").html(`You Complete the Game in ${duration} seconds`);
                    var request = $.ajax({
                        url: "update.php",
                        method: "GET",
                        data: {
                            score: score,
                            duration: duration
                        },
                        dataType: "html"
                    });
                }
            }

            function loop() {
                for (let i = 0; i < 10; i++) {
                    let nextquestion = movieArr.pop();
                    // console.log(nextquestion);
                    let movieQuestion = new Question(nextquestion.image, nextquestion.title, [nextquestion.title, movieArr[nextpointer + 1].title, movieArr[nextpointer + 2].title, movieArr[nextpointer + 3].title]);
                    nextpointer += 2;
                    // console.log(nextquestion.title);
                    questionBank.push(movieQuestion);

                }
                console.log(questionBank);
            }

            $('#playb').click(function() {
                $('#mainUi').removeClass('d-none');
                $('#quizUi').addClass('d-none');
                $('#player_name').val('');
                location.reload();
                // alert('3333333');
            })



            updateUI();

            function updateUI() {
                $('#image').attr('src', './images/' + questionBank[Pointer].poster + '.jpg');
                $('#a').html(questionBank[Pointer].choices[0]).val(questionBank[Pointer].choices[0]);
                $('#b').html(questionBank[Pointer].choices[1]).val(questionBank[Pointer].choices[1]);
                $('#c').html(questionBank[Pointer].choices[2]).val(questionBank[Pointer].choices[2]);
                $('#d').html(questionBank[Pointer].choices[3]).val(questionBank[Pointer].choices[3]);
            }




        })
    </script>
</body>