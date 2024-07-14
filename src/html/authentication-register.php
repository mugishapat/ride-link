<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ridelink</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                        <div class="card-body">
    <a href="./index.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
        <img src="../assets/images/logos/logo.png" width="100" alt="">
        <span class="ml-2 align-middle" style="font-size: 2em; font-weight: bold; color: black;">Ridelink</span>
    </a>
    <p class="text-center">Your Information</p>
    <form method="post" action="register.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="textHelp">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" onchange="showDocumentsFields()">
                <option value="">Select Role</option>
                <option value="passenger">Passenger</option>
                <option value="temporary_driver">Temporary Driver</option>
                <option value="private_driver">Private Driver</option>
                <option value="car_owner">Car Owner</option>
            </select>
        </div>
        <div class="mb-3" id="idDocumentField" style="display: none;">
            <label for="idDocument" class="form-label">ID Document</label>
            <input type="file" class="form-control" id="idDocument" name="idDocument">
        </div>
        <div class="mb-3" id="drivingLicenseField" style="display: none;">
            <label for="drivingLicense" class="form-label">Driving License</label>
            <input type="file" class="form-control" id="drivingLicense" name="drivingLicense">
        </div>
        <div class="mb-3" id="vehicleRegistrationField" style="display: none;">
            <label for="vehicleRegistration" class="form-label">Vehicle Registration</label>
            <input type="file" class="form-control" id="vehicleRegistration" name="vehicleRegistration">
        </div>
        <!-- New fields for car owners -->
        <div class="mb-3" id="vehicleMake" style="display: none;">
            <label for="vehicleMake" class="form-label">Vehicle Make</label>
            <input type="text" class="form-control" id="vehicleMake" name="vehicleMake">
        </div>
        <div class="mb-3" id="vehicleModel" style="display: none;">
            <label for="vehicleModel" class="form-label">Vehicle Model</label>
            <input type="text" class="form-control" id="vehicleModel" name="vehicleModel">
        </div>
        <div class="mb-3" id="vehicleYear" style="display: none;">
            <label for="vehicleYear" class="form-label">Vehicle Year</label>
            <input type="number" class="form-control" id="vehicleYear" name="vehicleYear">
        </div>
        <!-- End of new fields -->
        <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded-2">Sign Up</button>
        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
            <a class="text-primary fw-bold ms-2" href="./index.php">Sign In</a>
        </div>
    </form>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showDocumentsFields() {
    var roleSelect = document.getElementById("role");
    var selectedRole = roleSelect.options[roleSelect.selectedIndex].value;

    // Get all field elements
    var idDocumentField = document.getElementById("idDocumentField");
    var idDocumentInput = document.getElementById("idDocument");

    var drivingLicenseField = document.getElementById("drivingLicenseField");
    var drivingLicenseInput = document.getElementById("drivingLicense");

    var vehicleRegistrationField = document.getElementById("vehicleRegistrationField");
    var vehicleRegistrationInput = document.getElementById("vehicleRegistration");

    var vehicleMakeField = document.getElementById("vehicleMake");
    var vehicleMakeInput = document.getElementById("vehicleMake");

    var vehicleModelField = document.getElementById("vehicleModel");
    var vehicleModelInput = document.getElementById("vehicleModel");

    var vehicleYearField = document.getElementById("vehicleYear");
    var vehicleYearInput = document.getElementById("vehicleYear");

    // Hide and remove required attribute from all fields by default
    idDocumentField.style.display = "none";
    idDocumentInput.removeAttribute("required");

    drivingLicenseField.style.display = "none";
    drivingLicenseInput.removeAttribute("required");

    vehicleRegistrationField.style.display = "none";
    vehicleRegistrationInput.removeAttribute("required");

    vehicleMakeField.style.display = "none";
    vehicleMakeInput.removeAttribute("required");

    vehicleModelField.style.display = "none";
    vehicleModelInput.removeAttribute("required");

    vehicleYearField.style.display = "none";
    vehicleYearInput.removeAttribute("required");

    // Show and add required attribute to fields based on selected role
    if (selectedRole === "temporary_driver" || selectedRole === "private_driver") {
        idDocumentField.style.display = "block";
        idDocumentInput.setAttribute("required", "required");

        drivingLicenseField.style.display = "block";
        drivingLicenseInput.setAttribute("required", "required");
    }
    if (selectedRole === "private_driver") {
        vehicleRegistrationField.style.display = "block";
        vehicleRegistrationInput.setAttribute("required", "required");
    }
    if (selectedRole === "car_owner") {
        vehicleMakeField.style.display = "block";
        vehicleMakeInput.setAttribute("required", "required");

        vehicleModelField.style.display = "block";
        vehicleModelInput.setAttribute("required", "required");

        vehicleYearField.style.display = "block";
        vehicleYearInput.setAttribute("required", "required");
    }
}

    </script>
</body>

</html>
