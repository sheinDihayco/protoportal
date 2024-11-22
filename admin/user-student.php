<?php include_once "../templates/header.php" ?>;
<?php include_once '../PHP/user-student-con.php' ?>
<?php include('modals/register-student.php'); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Student Account Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent"></button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Search Students <span>| Enrolled</span></h5>
                <form method="GET" action="" class="row g-3 align-items-center">
                    <div class="col-md-8 d-flex gap-2">
                        <input type="text" class="form-control" name="search_user" placeholder="Enter Student ID (e.g., MIIT-0000-000)" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                    </div>
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
            <?php if (!empty($_GET['search_user'])): ?>
                <div class="col-12 tblStudents mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Results <span>| Enrolled Student</span></h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $database = new Connection();
                                    $db = $database->open();

                                    try {
                                        $search_user = htmlspecialchars($_GET['search_user']);
                                        $sql = "SELECT * FROM tbl_students WHERE user_name LIKE :search_user ORDER BY lname ASC";
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute(['search_user' => "%$search_user%"]);

                                        if ($stmt->rowCount() > 0) {
                                            while ($row = $stmt->fetch()) {
                                    ?>
                                                <tr>
                                                    <th scope="row" class="font-weight-bold"><a href="#"><?php echo $row["user_name"]; ?></a></th>
                                                    <td><?php echo "{$row["lname"]}, {$row["fname"]}"; ?></td>
                                                    <td>
                                                        <?php if (htmlspecialchars($row['status']) == 'Enrolled'): ?>
                                                            <span class="badge badge-success">Enrolled</span>
                                                        <?php elseif (htmlspecialchars($row['status']) == 'Unenrolled'): ?>
                                                            <span class="badge badge-danger">Unenrolled</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Not Available</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <form action="student_profile.php" method="post" style="display:inline;">
                                                            <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                                            <button type="submit" class="btn btn-sm btn-success" name="submit" title="View Profile">
                                                                <i class="ri-arrow-right-circle-fill"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="../admin/upload/delete-student.php" style="display:inline;" onsubmit="return confirmDelete();">
                                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line" title="Delete"></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php include('modals/form-edit-Student.php'); ?>
                                    <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' class='text-danger'>No records found.</td></tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<p class='text-danger'>There was a problem connecting to the database: " . $e->getMessage() . "</p>";
                                    }

                                    $database->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
    </div>
</main>


<!-- Template Main JS File -->
<script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        if (role === 'student') {
            document.getElementById('usernameDiv').style.display = 'none';
            document.getElementById('schoolidDiv').style.display = 'block';
        } else {
            document.getElementById('usernameDiv').style.display = 'block';
            document.getElementById('schoolidDiv').style.display = 'none';
        }
    });
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
    .text-danger{
        font-style: italic;
        text-align: center;
    }

</style>
<?php include_once "../templates/footer.php" ?>;