<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <!-- Page Heading -->
    <h1>Teacher Management</h1>
    <p>Manage teachers for Rishton Academy: Add, view, and search teachers along with their annual salaries.</p>

    <!-- Add New Teacher Form -->
    <div class="add-class-form">
        <h2>Add New Teacher</h2>
        <form action="teachers.php" method="POST">
            <label for="teacher-name">Teacher Name:</label>
            <input type="text" id="teacher-name" name="teacher_name" placeholder="Enter teacher's name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter teacher's address" required>

            <label for="phone-number">Phone Number:</label>
            <input type="text" id="phone-number" name="phone_number" placeholder="Enter phone number" required>

            <label for="background-check">Background Check:</label>
            <input type="text" id="background-check" name="background_check" placeholder="Enter background check status" required>

            <label for="annual-salary">Annual Salary (in GBP):</label>
            <input type="number" id="annual-salary" name="annual_salary" placeholder="Enter annual salary" required>

            <button type="submit" name="add_teacher" class="submit-btn">Add Teacher</button>
        </form>
    </div>

    <!-- Teacher Table -->
    <div class="class-table-section">
        <h2>Available Teachers</h2>
        <table class="class-table">
            <thead>
                <tr>
                    <th>Teacher Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Background Check</th>
                    <th>Annual Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle adding a new teacher
                if (isset($_POST['add_teacher'])) {
                    $teacher_name = $_POST['teacher_name'];
                    $address = $_POST['address'];
                    $phone_number = $_POST['phone_number'];
                    $background_check = $_POST['background_check'];
                    $annual_salary = $_POST['annual_salary'];

                    // Insert new teacher data into Teachers table
                    $sql = "INSERT INTO Teachers (Name, Address, PhoneNumber, BackgroundCheck) VALUES ('$teacher_name', '$address', '$phone_number', '$background_check')";
                    if ($conn->query($sql) === TRUE) {
                        $teacher_id = $conn->insert_id; // Get the ID of the newly inserted teacher
                        
                        // Insert the salary data into the Salaries table
                        $salary_sql = "INSERT INTO Salaries (StaffType, StaffID, Amount, PaymentDate) VALUES ('Teacher', '$teacher_id', '$annual_salary', NOW())";
                        if ($conn->query($salary_sql) === TRUE) {
                            echo "<script>alert('Teacher added successfully!'); window.location='teachers.php';</script>";
                        } else {
                            echo "Error: " . $salary_sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Handle deleting a teacher
                if (isset($_GET['delete'])) {
                    $teacher_id = $_GET['delete'];
                    $delete_salary_sql = "DELETE FROM Salaries WHERE StaffID = $teacher_id AND StaffType = 'Teacher'";
                    $delete_teacher_sql = "DELETE FROM Teachers WHERE TeacherID = $teacher_id";
                    if ($conn->query($delete_salary_sql) === TRUE && $conn->query($delete_teacher_sql) === TRUE) {
                        echo "<script>alert('Teacher deleted successfully!'); window.location='teachers.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // Retrieve and display teachers along with their salaries
                $sql = "SELECT t.TeacherID, t.Name AS TeacherName, t.Address, t.PhoneNumber, t.BackgroundCheck, s.Amount AS AnnualSalary
                        FROM Teachers t
                        LEFT JOIN Salaries s ON t.TeacherID = s.StaffID AND s.StaffType = 'Teacher'";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Query failed: " . $conn->error);  // Output SQL error
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td data-label='Teacher Name'>" . $row['TeacherName'] . "</td>
                                <td data-label='Address'>" . $row['Address'] . "</td>
                                <td data-label='Phone Number'>" . $row['PhoneNumber'] . "</td>
                                <td data-label='Background Check'>" . $row['BackgroundCheck'] . "</td>
                                <td data-label='Annual Salary'>£" . number_format($row['AnnualSalary'], 2) . "</td>
                                <td data-label='Actions'>
                                    <a href='teachers.php?edit=" . $row['TeacherID'] . "' class='edit-btn'>Edit</a>
                                    <a href='teachers.php?delete=" . $row['TeacherID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this teacher?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No teachers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Teachers</h2>
        <input type="text" id="search-input" placeholder="Search by teacher name..." class="search-input">
        <button type="button" class="search-btn" onclick="searchTeachers()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
