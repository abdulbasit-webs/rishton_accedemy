<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<div class="container">
    <!-- Page Heading -->
    <h1>Parent Management</h1>
    <p>Manage parents for Rishton Academy: Add, view, and search parents.</p>

    <!-- Add New Parent Form -->
    <div class="add-class-form">
        <h2>Add New Parent</h2>
        <form action="parents.php" method="POST">
            <label for="parent-name">Parent Name:</label>
            <input type="text" id="parent-name" name="parent_name" placeholder="Enter parent's name" required>

            <label for="parent-address">Address:</label>
            <input type="text" id="parent-address" name="parent_address" placeholder="Enter parent's address" required>

            <label for="phone-number">Phone Number:</label>
            <input type="text" id="phone-number" name="phone_number" placeholder="Enter phone number" required>

            <label for="child-name">Assign a Pupil:</label>
            <select id="child-name" name="pupil_id" required>
                <option value="">Select Pupil</option>
                <?php
                // Retrieve pupils from the database
                $pupil_query = "SELECT PupilID, Name FROM Pupils";
                $pupil_result = $conn->query($pupil_query);

                if ($pupil_result->num_rows > 0) {
                    while ($pupil_row = $pupil_result->fetch_assoc()) {
                        echo "<option value='" . $pupil_row['PupilID'] . "'>" . $pupil_row['Name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No pupils available</option>";
                }
                ?>
            </select>

            <button type="submit" name="add_parent" class="submit-btn">Add Parent</button>
        </form>
    </div>

    <!-- Parent Table -->
    <div class="class-table-section">
        <h2>Available Parents</h2>
        <table class="class-table">
            <thead>
                <tr>
                    <th>Parent Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Assigned Pupil</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle adding a new parent
                if (isset($_POST['add_parent'])) {
                    $parent_name = $_POST['parent_name'];
                    $parent_address = $_POST['parent_address'];
                    $phone_number = $_POST['phone_number'];
                    $pupil_id = $_POST['pupil_id'];

                    // Insert new parent data into Parents_Guardians table
                    $sql = "INSERT INTO Parents_Guardians (Name, Address, PhoneNumber) VALUES ('$parent_name', '$parent_address', '$phone_number')";
                    if ($conn->query($sql) === TRUE) {
                        $parent_id = $conn->insert_id; // Get the ID of the newly inserted parent
                        $assign_pupil_sql = "INSERT INTO Pupils_Parents (PupilID, ParentID) VALUES ('$pupil_id', '$parent_id')";
                        if ($conn->query($assign_pupil_sql) === TRUE) {
                            echo "<script>alert('Parent added successfully!'); window.location='parents.php';</script>";
                        } else {
                            echo "Error: " . $assign_pupil_sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Handle deleting a parent
                if (isset($_GET['delete'])) {
                    $parent_id = $_GET['delete'];
                    $delete_pupil_parent_sql = "DELETE FROM Pupils_Parents WHERE ParentID = $parent_id";
                    $delete_parent_sql = "DELETE FROM Parents_Guardians WHERE ParentID = $parent_id";
                    if ($conn->query($delete_pupil_parent_sql) === TRUE && $conn->query($delete_parent_sql) === TRUE) {
                        echo "<script>alert('Parent deleted successfully!'); window.location='parents.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // Retrieve and display parents along with their assigned pupils
                $sql = "SELECT p.Name AS ParentName, p.Address, p.PhoneNumber, pup.Name AS ChildName, p.ParentID 
                        FROM Parents_Guardians p
                        LEFT JOIN Pupils_Parents pp ON p.ParentID = pp.ParentID
                        LEFT JOIN Pupils pup ON pp.PupilID = pup.PupilID";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Query failed: " . $conn->error);  // Output SQL error
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td data-label='Parent Name'>" . $row['ParentName'] . "</td>
                                <td data-label='Address'>" . $row['Address'] . "</td>
                                <td data-label='Phone Number'>" . $row['PhoneNumber'] . "</td>
                                <td data-label='Assigned Pupil'>" . $row['ChildName'] . "</td>
                                <td data-label='Actions'>
                                    <a href='parents.php?edit=" . $row['ParentID'] . "' class='edit-btn'>Edit</a>
                                    <a href='parents.php?delete=" . $row['ParentID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this parent?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No parents found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Parents</h2>
        <input type="text" id="search-input" placeholder="Search by parent name or pupil name..." class="search-input">
        <button type="button" class="search-btn" onclick="searchParents()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
