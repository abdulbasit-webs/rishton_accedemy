<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <!-- Page Heading -->
    <h1>Dinner Money Management</h1>
    <p>Manage dinner money records for pupils at Rishton Academy: Add, view, search, and delete dinner money entries.</p>

    <!-- Add New Dinner Money Entry Form -->
    <div class="add-dinner-money-form">
        <h2>Add New Dinner Money Entry</h2>
        <form action="diners_money.php" method="POST">
            <label for="pupil-id">Select Pupil:</label>
            <select id="pupil-id" name="pupil_id" required>
                <option value="">Select a pupil</option>
                <?php
                // Fetching pupils from the database
                $result = $conn->query("SELECT PupilID, Name FROM Pupils");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['PupilID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" placeholder="Enter amount" step="0.01" required>

            <label for="payment-date">Payment Date:</label>
            <input type="date" id="payment-date" name="payment_date" required>

            <button type="submit" name="add_dinner_money" class="submit-btn">Add Dinner Money</button>
        </form>
    </div>

    <!-- Handling Form Submission -->
    <?php
    if (isset($_POST['add_dinner_money'])) {
        $pupil_id = $_POST['pupil_id'];
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];

        // Inserting the new dinner money entry into the database
        $sql = "INSERT INTO DinnerMoney (PupilID, Amount, PaymentDate) VALUES ('$pupil_id', '$amount', '$payment_date')";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success-message'>Dinner money entry added successfully!</p>";
        } else {
            echo "<p class='error-message'>Error: " . $conn->error . "</p>";
        }
    }

    // Handle deleting a dinner money entry
    if (isset($_GET['delete'])) {
        $dinner_id = $_GET['delete'];
        $sql = "DELETE FROM DinnerMoney WHERE DinnerID = $dinner_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Dinner money entry deleted successfully!'); window.location='diners_money.php';</script>";
        } else {
            echo "<p class='error-message'>Error deleting record: " . $conn->error . "</p>";
        }
    }
    ?>

    <!-- Display Dinner Money Entries -->
    <div class="dinner-money-table-section">
        <h2>List of Dinner Money Entries</h2>
        <table class="dinner-money-table">
            <thead>
                <tr>
                    <th>Pupil Name</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching dinner money entries from the database
                $result = $conn->query("
                    SELECT DinnerMoney.DinnerID, Pupils.Name AS PupilName, DinnerMoney.Amount, DinnerMoney.PaymentDate
                    FROM DinnerMoney
                    JOIN Pupils ON DinnerMoney.PupilID = Pupils.PupilID
                ");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['PupilName'] . "</td>
                            <td>£" . number_format($row['Amount'], 2) . "</td>
                            <td>" . $row['PaymentDate'] . "</td>
                            <td>
                                <a href='diners_money.php?delete=" . $row['DinnerID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this entry?\")'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <h2>Search Dinner Money Entries</h2>
        <input type="text" id="search-input" placeholder="Search by pupil name..." class="search-input">
        <button type="button" class="search-btn" onclick="searchDinnerMoney()">Search</button>
        <div id="search-results">
            <!-- Search results will be dynamically displayed here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
