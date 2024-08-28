<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <!-- Page Heading -->
    <h1>Teaching Assistant Management</h1>
    <p>Manage teaching assistants for Rishton Academy: Add, view, and search teaching assistants.</p>

    <!-- Add New Teaching Assistant Form -->
    <div class="add-class-form">
        <h2>Add New Teaching Assistant</h2>
        <form action="teaching_assistant.php" method="POST">
            <label for="assistant-name">Assistant Name:</label>
            <input type="text" id="assistant-name" name="assistant_name" placeholder="Enter assistant's name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter assistant's address" required>

            <label for="phone-number">Phone Number:</label>
            <input type="text" id="phone-number" name="phone_number" placeholder="Enter phone number" required>

            <label for="background-check">Background Check:</label>
            <input type="text" id="background-check" name="background_check" placeholder="Enter background check status" required>

            <button type="submit" name="add_assistant" class="submit-btn">Add Assistant</button>
        </form>
    </div>

    <!-- Teaching Assistant Table -->
    <div class="class-table-section">
        <h2>Available Teaching Assistants</h2>
        <table class="class-table">
            <thead>
                <tr>
                    <th>Assistant Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Background Check</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle adding a new teaching assistant
                if (isset($_POST['add_assistant'])) {
                    $assistant_name = $_POST['assistant_name'];
                    $address = $_POST['address'];
                    $phone_number = $_POST['phone_number'];
                    $background_check = $_POST['background_check'];

                    // Insert new teaching assistant data into TeachingAssistants table
                    $sql = "INSERT INTO TeachingAssistants (Name, Address, PhoneNumber, BackgroundCheck) VALUES ('$assistant_name', '$address', '$phone_number', '$background_check')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Teaching Assistant added successfully!'); window.location='teaching_assistant.php';</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Handle deleting a teaching assistant
                if (isset($_GET['delete'])) {
                    $assistant_id = $_GET['delete'];
                    $delete_sql = "DELETE FROM TeachingAssistants WHERE AssistantID = $assistant_id";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo "<script>alert('Teaching Assistant deleted successfully!'); window.location='teaching_assistant.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // Retrieve and display teaching assistants
                $sql = "SELECT AssistantID, Name, Address, PhoneNumber, BackgroundCheck FROM TeachingAssistants";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Query failed: " . $conn->error);  // Output SQL error
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td data-label='Assistant Name'>" . $row['Name'] . "</td>
                                <td data-label='Address'>" . $row['Address'] . "</td>
                                <td data-label='Phone Number'>" . $row['PhoneNumber'] . "</td>
                                <td data-label='Background Check'>" . $row['BackgroundCheck'] . "</td>
                                <td data-label='Actions'>
                                    <a href='teaching_assistant.php?edit=" . $row['AssistantID'] . "' class='edit-btn'>Edit</a>
                                    <a href='teaching_assistant.php?delete=" . $row['AssistantID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this assistant?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No teaching assistants found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Teaching Assistants</h2>
        <input type="text" id="search-input" placeholder="Search by assistant name..." class="search-input">
        <button type="button" class="search-btn" onclick="searchAssistants()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
