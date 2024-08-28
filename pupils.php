<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <!-- Page Heading -->
    <h1>Pupil Management</h1>
    <p>Manage pupils for Rishton Academy: Add, view, and search pupils.</p>

    <!-- Add New Pupil Form -->
    <div class="add-class-form">
        <h2>Add New Pupil</h2>
        <form action="pupils.php" method="POST">
            <label for="pupil-name">Pupil Name:</label>
            <input type="text" id="pupil-name" name="pupil_name" placeholder="Enter pupil's name" required>

            <label for="pupil-address">Address:</label>
            <input type="text" id="pupil-address" name="pupil_address" placeholder="Enter pupil's address" required>

            <label for="medical-info">Medical Information:</label>
            <textarea id="medical-info" name="medical_info" placeholder="Enter any relevant medical information" required></textarea>

            <!-- Class Selection -->
            <label for="class">Assign a Class:</label>
            <select id="class" name="class_id" required>
                <option value="">Select Class</option>
                <?php
                // Retrieve classes from the database
                $class_query = "SELECT ClassID, ClassName FROM Classes";
                $class_result = $conn->query($class_query);

                if ($class_result->num_rows > 0) {
                    while ($class_row = $class_result->fetch_assoc()) {
                        echo "<option value='" . $class_row['ClassID'] . "'>" . $class_row['ClassName'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No classes available</option>";
                }
                ?>
            </select>

            <button type="submit" name="add_pupil" class="submit-btn">Add Pupil</button>
        </form>
    </div>

    <!-- Pupil Table -->
    <div class="class-table-section">
        <h2>Available Pupils</h2>
        <table class="class-table">
            <thead>
                <tr>
                    <th>Pupil Name</th>
                    <th>Address</th>
                    <th>Medical Info</th>
                    <th>Assigned Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle adding a new pupil
                if (isset($_POST['add_pupil'])) {
                    $pupil_name = $_POST['pupil_name'];
                    $pupil_address = $_POST['pupil_address'];
                    $medical_info = $_POST['medical_info'];
                    $class_id = $_POST['class_id'];

                    $sql = "INSERT INTO Pupils (Name, Address, MedicalInfo, ClassID) VALUES ('$pupil_name', '$pupil_address', '$medical_info', '$class_id')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Pupil added successfully!'); window.location='pupils.php';</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Handle deleting a pupil
                if (isset($_GET['delete'])) {
                    $pupil_id = $_GET['delete'];
                    $sql = "DELETE FROM Pupils WHERE PupilID = $pupil_id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Pupil deleted successfully!'); window.location='pupils.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // Retrieve and display pupils
                $sql = "SELECT p.Name as PupilName, p.Address, p.MedicalInfo, c.ClassName, p.PupilID FROM Pupils p LEFT JOIN Classes c ON p.ClassID = c.ClassID";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['PupilName'] . "</td>
                                <td>" . $row['Address'] . "</td>
                                <td>" . $row['MedicalInfo'] . "</td>
                                <td>" . $row['ClassName'] . "</td>
                                <td>
                                    <a href='pupils.php?edit=" . $row['PupilID'] . "' class='edit-btn'>Edit</a>
                                    <a href='pupils.php?delete=" . $row['PupilID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this pupil?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No pupils found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Pupils</h2>
        <input type="text" id="search-input" placeholder="Search by pupil name or class..." class="search-input">
        <button type="button" class="search-btn" onclick="searchPupils()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
