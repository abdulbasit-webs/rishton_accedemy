<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <!-- Page Heading -->
    <h1>Salaries Management</h1>
    <p>Manage salaries for teachers and teaching assistants: Add, view, edit, search, and delete salary entries.</p>

    <!-- Add or Edit Salary Entry Form -->
    <div class="add-salary-form">
        <h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Salary Entry</h2>
        <form action="salaries.php" method="POST">
            <input type="hidden" name="salary_id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
            
            <label for="staff-type">Select Staff Type:</label>
            <select id="staff-type" name="staff_type" required>
                <option value="">Select staff type</option>
                <option value="Teacher" <?php echo isset($staff_type) && $staff_type == 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                <option value="TeachingAssistant" <?php echo isset($staff_type) && $staff_type == 'TeachingAssistant' ? 'selected' : ''; ?>>Teaching Assistant</option>
            </select>

            <label for="staff-id">Select Staff Member:</label>
            <select id="staff-id" name="staff_id" required>
                <option value="">Select a staff member</option>
            </select>

            <label for="amount">Amount (in GBP):</label>
            <input type="number" id="amount" name="amount" placeholder="Enter amount" step="0.01" value="<?php echo isset($amount) ? $amount : ''; ?>" required>

            <label for="payment-date">Payment Date:</label>
            <input type="date" id="payment-date" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>" required>

            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'update_salary' : 'add_salary'; ?>" class="submit-btn"><?php echo isset($_GET['edit']) ? 'Update' : 'Add'; ?> Salary</button>
        </form>
    </div>

    <!-- Handle Adding or Updating Salary -->
    <?php
    if (isset($_POST['add_salary']) || isset($_POST['update_salary'])) {
        $salary_id = isset($_POST['salary_id']) ? $_POST['salary_id'] : null;
        $staff_type = $_POST['staff_type'];
        $staff_id = $_POST['staff_id'];
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];

        if (isset($_POST['update_salary'])) {
            // Update existing salary entry
            $sql = "UPDATE Salaries SET StaffType='$staff_type', StaffID='$staff_id', Amount='$amount', PaymentDate='$payment_date' WHERE SalaryID='$salary_id'";
        } else {
            // Insert new salary entry
            $sql = "INSERT INTO Salaries (StaffType, StaffID, Amount, PaymentDate) VALUES ('$staff_type', '$staff_id', '$amount', '$payment_date')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Salary entry " . (isset($_POST['update_salary']) ? 'updated' : 'added') . " successfully!'); window.location='salaries.php';</script>";
        } else {
            echo "<p class='error-message'>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Deleting a Salary Entry
    if (isset($_GET['delete'])) {
        $salary_id = $_GET['delete'];
        $sql = "DELETE FROM Salaries WHERE SalaryID = $salary_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Salary entry deleted successfully!'); window.location='salaries.php';</script>";
        } else {
            echo "<p class='error-message'>Error deleting record: " . $conn->error . "</p>";
        }
    }

    // Fetch Salary Entries from the Database
    $query = "
        SELECT Salaries.SalaryID, Salaries.StaffType, 
               IF(Salaries.StaffType='Teacher', Teachers.Name, TeachingAssistants.Name) AS StaffName,
               Salaries.Amount, Salaries.PaymentDate
        FROM Salaries
        LEFT JOIN Teachers ON Salaries.StaffType='Teacher' AND Salaries.StaffID=Teachers.TeacherID
        LEFT JOIN TeachingAssistants ON Salaries.StaffType='TeachingAssistant' AND Salaries.StaffID=TeachingAssistants.AssistantID
    ";

    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);  // Output SQL error to diagnose the issue
    }
    ?>

    <!-- Display Salary Entries -->
    <div class="salary-table-section">
        <h2>List of Salary Entries</h2>
        <table class="salary-table">
            <thead>
                <tr>
                    <th>Staff Type</th>
                    <th>Staff Name</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['StaffType'] . "</td>
                                <td>" . $row['StaffName'] . "</td>
                                <td>£" . number_format($row['Amount'], 2) . "</td>
                                <td>" . $row['PaymentDate'] . "</td>
                                <td>
                                    <a href='salaries.php?edit=" . $row['SalaryID'] . "' class='edit-btn'>Edit</a>
                                    <a href='salaries.php?delete=" . $row['SalaryID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this entry?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No salary entries found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- JavaScript for Dynamic Dropdown and Search -->
<script src="js/salaries.js"></script>
