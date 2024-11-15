<?php include_once "../templates/header.php";?>

<main id="main" class="main">

<div class="pagetitle">
    <h1>Payment Records</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Student</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container">
    <div class="card">
        <div class="card-body">
                <h5 class="card-title">School ID <span>| Enrolled</span></h5>
            <!-- Search Form -->
            <form method="GET" action="" class="row g-3 align-items-center">
                <!-- Search Input -->
                <div class="col-md-8 d-flex gap-2">
                    <input type="text" class="form-control" name="search_user" placeholder="Enter Student ID (e.g., MIIT-0000-000)" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                </div>

                <!-- Search and Clear Buttons -->
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" name="search" class="btn btn-primary" title="Search">
                        <i class="bx bx-search-alt"></i> Search
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearInputField()" title="Clear Search">
                        <i class="bx bx-eraser"></i> Clear
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
    // Only display the table if search_user is not empty
    if (isset($_GET['search_user']) && !empty($_GET['search_user'])):
    ?>
        <!-- Display Table -->
        <div class="col-12 tblStudents">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Result <span>| Enrolled Student</span></h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                // Query to fetch students based on search criteria
                                $search_user = htmlspecialchars($_GET['search_user']);
                                $sql = "SELECT * FROM tbl_students WHERE user_name LIKE :search_user ORDER BY lname ASC";
                                $stmt = $db->prepare($sql);
                                $stmt->execute(['search_user' => "%$search_user%"]);

                                while ($row = $stmt->fetch()) {
                            ?>
                                <tr>
                                    <th scope="row" style="font-weight:bold;"><a href=""><?php echo $row["user_name"] ?></a></th>
                                    <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                                    <td>
                                        <?php if (htmlspecialchars($row['status']) == 'Enrolled'): ?>
                                            <span class="badge badge-success">Enrolled</span>
                                        <?php elseif (htmlspecialchars($row['status']) == 'UnEnrolled'): ?>
                                            <span class="badge badge-danger">UnEnrolled</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Not Available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Action Buttons -->
                                        <form action="student_profile.php" method="post" style="display:inline;">
                                            <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-success" name="submit">
                                                <i class="ri-arrow-right-circle-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                }
                            } catch (PDOException $e) {
                                echo "There is some problem in connection: " . $e->getMessage();
                            }
                            $database->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
</div>

</main><!-- End #main -->

<!-- JavaScript to Clear the Search Input Field -->
<script>
    function clearInputField() {
        document.querySelector('input[name="search_user"]').value = '';

        // Hide the table by setting its display style to 'none'
        const resultTable = document.querySelector(".tblStudents");
        if (resultTable) {
            resultTable.style.display = 'none';
        }
    }
</script>

<style>
    .badge-success {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-danger {
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-secondary {
        background-color: gray;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

</style>
<?php
include_once "../templates/footer.php";
?>