<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<div class="container">
    <!-- Page Heading -->
    <h1>Class Management</h1>
    <p>Manage classes for Rishton Academy: Reception Year to Year Six</p>

    <!-- Add New Class Form -->
    <div class="add-class-form">
        <h2>Add New Class</h2>
        <form action="classes.php" method="POST">
            <label for="class-name">Class Name:</label>
            <select id="class-name" name="class_name" required>
                <option value="">Select Class</option>
                <option value="Reception Year">Reception Year</option>
                <option value="Year One">Year One</option>
                <option value="Year Two">Year Two</option>
                <option value="Year Three">Year Three</option>
                <option value="Year Four">Year Four</option>
                <option value="Year Five">Year Five</option>
                <option value="Year Six">Year Six</option>
            </select>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" placeholder="Enter capacity (e.g., 30)" required>

            <!-- Teacher Selection -->
            <label for="teacher">Assign a Teacher:</label>
            <select id="teacher" name="teacher_id" required>
                <option value="">Select Teacher</option>
                <?php
                // Retrieve teachers from the database
                $teacher_query = "SELECT TeacherID, Name FROM Teachers";
                $teacher_result = $conn->query($teacher_query);

                if ($teacher_result->num_rows > 0) {
                    while ($teacher_row = $teacher_result->fetch_assoc()) {
                        echo "<option value='" . $teacher_row['TeacherID'] . "'>" . $teacher_row['Name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No teachers available</option>";
                }
                ?>
            </select>

            <button type="submit" name="add_class" class="submit-btn">Add Class</button>
        </form>
    </div>

    <!-- Class Table -->
    <div class="class-table-section">
        <h2>Available Classes</h2>
        <table class="class-table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Capacity</th>
                    <th>Assigned Teacher</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle adding a new class
                if (isset($_POST['add_class'])) {
                    $class_name = $_POST['class_name'];
                    $capacity = $_POST['capacity'];
                    $teacher_id = $_POST['teacher_id'];

                    $sql = "INSERT INTO Classes (ClassName, Capacity, ClassID) VALUES ('$class_name', '$capacity', '$teacher_id')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Class added successfully!'); window.location='classes.php';</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Handle deleting a class
                if (isset($_GET['delete'])) {
                    $class_id = $_GET['delete'];
                    $sql = "DELETE FROM Classes WHERE ClassID = $class_id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Class deleted successfully!'); window.location='classes.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // Retrieve and display classes
                $sql = "SELECT c.ClassName, c.Capacity, t.Name as TeacherName, c.ClassID FROM Classes c LEFT JOIN Teachers t ON c.ClassID = t.TeacherID";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td data-label='Class Name'>" . $row['ClassName'] . "</td>
                                <td data-label='Capacity'>" . $row['Capacity'] . "</td>
                                <td data-label='Assigned Teacher'>" . $row['TeacherName'] . "</td>
                                <td data-label='Actions'>
                                    <a href='classes.php?edit=" . $row['ClassID'] . "' class='edit-btn'>Edit</a>
                                    <a href='classes.php?delete=" . $row['ClassID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this class?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No classes found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Classes</h2>
        <input type="text" id="search-input" placeholder="Search by class name or teacher..." class="search-input">
        <button type="button" class="search-btn" onclick="searchClasses()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/scripts.js"></script>
