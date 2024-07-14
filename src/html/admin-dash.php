
<?php
include 'config.php';

$countQuery = "SELECT COUNT(*) AS userCount FROM users";
$countResult = $conn->query($countQuery);
$userCount = $countResult && $countResult->num_rows > 0 ? $countResult->fetch_assoc()['userCount'] : 0;

$pendingQuery = "SELECT COUNT(*) AS pendingCount FROM booking_details WHERE status = 'pending'";
$pendingResult = $conn->query($pendingQuery);
$pendingCount = $pendingResult && $pendingResult->num_rows > 0 ? $pendingResult->fetch_assoc()['pendingCount'] : 0;

$acceptedQuery = "SELECT COUNT(*) AS acceptedCount FROM booking_details WHERE status = 'accepted'";
$acceptedResult = $conn->query($acceptedQuery);
$acceptedCount = $acceptedResult && $acceptedResult->num_rows > 0 ? $acceptedResult->fetch_assoc()['acceptedCount'] : 0;

$bookingSql = "SELECT * FROM booking_details";
$bookingResult = $conn->query($bookingSql);

$userSql = "SELECT * FROM users";
$userResult = $conn->query($userSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ridelink</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>
    <div class="body-wrapper">
        <!-- Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2">Ridelink</i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">My Profile</p>
                                    </a>
                                    <a href="admin_logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Header End -->
        <div class="container-fluid">
            <!-- Row 1 -->
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card overflow-hidden rounded-2">
                        <div class="card-body pt-3 p-4">
                            <h6 class="fw-semibold fs-4">Users</h6>
                            <p class="fs-5">
                                <span id="userCountPlaceholder" class="display-1 fw-bold"><?php echo $userCount; ?></span><span>Users</span>
                            </p>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userTableModal">View Users</a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="userTableModal" tabindex="-1" aria-labelledby="userTableModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userTableModalLabel">Users Table</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="userTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Registration Date</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($userResult->num_rows > 0) {
                                                while ($row = $userResult->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["user_id"] . "</td>";
                                                    echo "<td>" . $row["name"] . "</td>";
                                                    echo "<td>" . $row["email"] . "</td>";
                                                    echo "<td>" . $row["role"] . "</td>";
                                                    echo "<td>" . $row["registration_date"] . "</td>";
                                                    echo "<td><button class='btn btn-danger btn-sm btn-delete' data-id='" . $row["user_id"] . "'>Delete</button></td>";
                                                    echo "</tr>";
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card overflow-hidden rounded-2">
                        <div class="card-body pt-3 p-4">
                            <h6 class="fw-semibold fs-4">Pending Rides</h6>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-time fs-2 text-warning"></i>
                                </div>
                                <div>
                                    <p class="fs-5 mb-0">
                                        <span id="pendingCountPlaceholder" class="display-1 fw-bold"><?php echo $pendingCount; ?></span><span> Pending</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card overflow-hidden rounded-2">
                        <div class="card-body pt-3 p-4">
                            <h6 class="fw-semibold fs-4">Accepted Rides</h6>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-check fs-2 text-success"></i>
                                </div>
                                <div>
                                    <p class="fs-5 mb-0">
                                        <span id="acceptedCountPlaceholder" class="display-1 fw-bold"><?php echo $acceptedCount; ?></span><span> Accepted</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card overflow-hidden rounded-2">
                        <div class="card-body pt-3 p-4">
                            <h6 class="fw-semibold fs-4">User Categories</h6>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Passengers</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Private Drivers</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Car-Owners</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Temp-Drivers</div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Transport information</h5>
                    <div class="table-responsive">
                        <table id="transactionTable" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Booking ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Driver ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Driver Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Pickup Location</h6>
                                        </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Destination Location</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Booking Time</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">User ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Delete</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($bookingResult->num_rows > 0) {
                                    while ($row = $bookingResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["booking_id"] . "</td>";
                                        echo "<td>" . $row["driver_id"] . "</td>";
                                        echo "<td>" . $row["driver_name"] . "</td>";
                                        echo "<td>" . $row["pickup_location"] . "</td>";
                                        echo "<td>" . $row["destination_location"] . "</td>";
                                        echo "<td>" . $row["booking_time"] . "</td>";
                                        echo "<td>" . $row["status"] . "</td>";
                                        echo "<td>" . $row["user_id"] . "</td>";
                                        echo "<td><button class='btn btn-danger btn-sm btn-delete' data-id='" . $row["booking_id"] . "'>Delete</button></td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <footer class="footer fixed-bottom">
                <div class="container-fluid">
                    <div class="py-3 px-6 text-center">
                        <p class="mb-0 fs-5">Designed and Developed by Ridelink</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables for all tables
            $('#userTable, #transactionTable').DataTable({
                "paging": true,
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50, 100],
                "searching": true,
                "info": true,
                "autoWidth": false
            });

            // Function to handle click event of delete buttons
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id'); // Get the id of the record to delete
                var table = $(this).closest('table').attr('id'); // Get the table id
                if (confirm("Are you sure you want to delete this record?")) {
                    // Perform AJAX request to delete the record
                    $.ajax({
                        url: 'delete_record.php', // Endpoint to delete record
                        method: 'POST',
                        data: { id: id, table: table }, // Send id and table name to the server
                        success: function(response) {
                            // Handle success response
                            alert(response); // Show success message
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText); // Log error message
                            alert("An error occurred while deleting the record."); // Show error message
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>