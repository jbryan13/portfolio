<?php
require_once 'config.php';
$provinces = $conn->query("SELECT * FROM provinces");
$citizens = $conn->query("SELECT CZ.id, CONCAT(CZ.firstname,' ',CZ.middlename,' ',CZ.lastname)AS name,CZ.birthdate ,CZ.gender ,CT.name as city, P.name as province 
FROM citizens AS CZ JOIN cities AS CT ON CZ.city_id = CT.id JOIN provinces AS P ON CT.province_id= P.id;");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <title>NID Form</title>
</head>

<body class="container">
    <div class="m-auto">
        <h1>National ID Registration Form</h1>
    </div>
    <form action="save.php" method="POST">
        <label for="lastName">Last name: </label>
        <input type="text" id="lastName" name="lastName" class="form-control" required>
        <br><br>

        <label for="firstName">First name: </label>
        <input type="text" id="firstName" name="firstName" class="form-control" required>
        <br><br>

        <label for="middleName">Middle name: </label>
        <input type="text" id="middleName" name="middleName" class="form-control" required>
        <br> <br>

        <label for="birthDate">Birth date: </label>
        <input type="date" id="birthDate" name="birthDate" class="form-control" required>
        <br><br>

        <span>Gender:</span> <br>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male"> Male</label> <br>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female"> Female</label> <br><br>

        <label for="province">Province: </label>
        <select id="province" name="province">
            <option value=""> Please select </option>
            <?php
            while ($province = $provinces->fetch_assoc()) {
                echo "<option value='" . $province['id'] . "'>" . $province['name'] . "</option>";
            }
            ?>
        </select> <br> <br>

        <label for='city'>Town/City: </label>
        <select id="city" name="city">
            <!-- dynamically pulled from provided sql schema under the cities table. selection options will automatically change once province selection is changed -->
            <option value=""> Please select </option>
        </select> <br> <br>

        <!-- <button type="submit">Submit</button> -->
        <button type="submit">Add</button>
    </form>
    <br><br>

    <table style="border:solid;" class="table table-striped table-bordered>
        <caption>
            Registered Members
        </caption>

        <thead class=" fixedHeader">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>B-Date</th>
            <th>Gender</th>
            <th>Town/City</th>
            <th>Province</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>

        <tbody>
            <?php
            while ($citizen = $citizens->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $citizen['id']; ?></td>
                    <td><?php echo $citizen['name']; ?></td>
                    <td><?php echo $citizen['birthdate']; ?></td>
                    <td><?php echo $citizen['gender']; ?></td>
                    <td><?php echo $citizen['city']; ?></td>
                    <td><?php echo $citizen['province']; ?></td>
                    <td><button type="button" class="btn btn-primary update" data-bs-toggle="modal" data-bs-target="#modalId" value="<?php echo $citizen['id']; ?>">Update</button></td>
                    <td><a href="delete.php?id=<?php echo $citizen['id']; ?>">Delete</a></td>
                </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
    <!-- Modal trigger button -->
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" role="dialog" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="lastNameMod" class="form-label">Last name: </label>
                        <input type="text" name="lastNameMod" id="lastNameMod" class="form-control" required /> <br />
                        <br />

                        <label for="firstNameMod" class="form-label">First name: </label>

                        <input type="text" name="firstNameMod" id="firstNameMod" class="form-control" required /> <br />
                        <br />

                        <label for="middleNameMod" class="form-label">Middle name: </label>
                        <input type="text" name="middleNameMod" id="middleNameMod" class="form-control" required /> <br /> <br />
                        <br />

                        <label for="birthDateMod" class="form-label">Birth date: </label>
                        <input type="date" name="birthDateMod" id="birthDateMod" class="form-control" required /> <br />
                        <br />

                        <span>Gender:</span> <br />
                        <label for="maleMod"> Male</label>
                        <input type="radio" id="maleMod" name="genderMod" value="male" required />
                        <br>
                        <label for="femaleMod"> Female</label>
                        <input type="radio" id="femaleMod" name="genderMod" value="female" required /> <br /><br />

                        <label for="provinceMod">Province: </label>
                        <select name="provinceMod" id="provinceMod">
                            <!-- dynamically pulled from the provided sql schema under the provinces table-->
                            <option value="">Please select</option>
                        </select>
                        <br />
                        <br />

                        <label for="cityMod">Town/City: </label>
                        <select name="cityMod" id="cityMod">
                            <!-- dynamically pulled from provided sql schema under the cities table. selection options will automatically change once province selection is changed -->
                            <option value="">Please select</option>
                        </select>
                        <br />
                        <br />

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script>
    <script>
        $(document).ready(function() {
            $('#province').change(function() {
                var request = $.ajax({
                    url: "cities.php",
                    method: "GET",
                    data: {
                        id: this.value
                    },
                    dataType: "html"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $("#city").html(msg);
                });
            });

            $('.update').click(function() {
                // alert(this.value);
                var request = $.ajax({
                    url: "citizens.php",
                    method: "GET",
                    data: {
                        id: this.value
                    },
                    dataType: "json"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $("#firstNameMod").val(msg.firstname);
                    $("#lastNameMod").val(msg.lastname);
                    $("#middleNameMod").val(msg.middlename);
                    $("#birthDateMod").val(msg.birthdate);
                    $("#id").val(msg.id);

                    if (msg.gender == 'male') {
                        $("#maleMod").attr("checked", "true");
                    } else {
                        $("#femaleMod").attr("checked", "true");
                    };
                    // alert(msg.city_id);

                    fetchProvinces(msg.province_id);
                    fetchCities2(msg.province_id, msg.city_id);

                });
            });

            $('#provinceMod').change(function() {
                var request = $.ajax({
                    url: "citiesMod.php",
                    method: "GET",
                    data: {
                        id: this.value
                    },
                    dataType: "html"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $("#cityMod").html(msg);
                });
            });

            function fetchProvinces(selectedId) {
                var request = $.ajax({
                    url: "provinces.php",
                    method: "GET",
                    data: {
                        selectedId: selectedId
                    },
                    dataType: "html"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $("#provinceMod").html(msg);
                });
            }

            function fetchCities2(province_id, city_select) {
                var request = $.ajax({
                    url: "cities2.php",
                    method: "GET",
                    data: {
                        province_id: province_id,
                        city_select: city_select
                    },
                    dataType: "html"
                });

                request.done(function(msg) {
                    // alert(msg);
                    $("#cityMod").html(msg);
                });
            }


        })
    </script>



</body>

</html>