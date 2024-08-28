<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>
<link rel="stylesheet" href="css/library_books.css">

<div class="container">
    <!-- Page Heading -->
    <h1>Library Books Management</h1>
    <p>Manage the books available in the Rishton Academy library: Add, view, search, edit, and delete books.</p>

    <!-- Handle Adding, Editing, and Deleting Books -->
    <?php
    if (isset($_POST['add_book']) || isset($_POST['edit_book'])) {
        $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;
        $book_title = $_POST['book_title'];
        $author = $_POST['author'];
        $publication_year = $_POST['publication_year'];
        $isbn = $_POST['isbn'];

        if (isset($_POST['edit_book'])) {
            // Update existing book entry
            $sql = "UPDATE LibraryBooks SET Title='$book_title', Author='$author', PublicationYear='$publication_year', ISBN='$isbn' WHERE BookID='$book_id'";
        } else {
            // Insert new book entry
            $sql = "INSERT INTO LibraryBooks (Title, Author, PublicationYear, ISBN) VALUES ('$book_title', '$author', '$publication_year', '$isbn')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Book " . (isset($_POST['edit_book']) ? 'updated' : 'added') . " successfully!'); window.location='library_books.php';</script>";
        } else {
            echo "<p class='error-message'>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Deleting a Book
    if (isset($_GET['delete'])) {
        $book_id = $_GET['delete'];
        $sql = "DELETE FROM LibraryBooks WHERE BookID = $book_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Book deleted successfully!'); window.location='library_books.php';</script>";
        } else {
            echo "<p class='error-message'>Error deleting record: " . $conn->error . "</p>";
        }
    }

    // Fetch and populate the form with data if editing
    if (isset($_GET['edit'])) {
        $book_id = $_GET['edit'];
        $sql = "SELECT * FROM LibraryBooks WHERE BookID = $book_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $book_title = $row['Title'];
            $author = $row['Author'];
            $publication_year = $row['PublicationYear'];
            $isbn = $row['ISBN'];
        }
    }
    ?>

    <!-- Add/Edit Book Form -->
    <div class="add-book-form">
    <h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Book</h2>
    <form action="library_books.php" method="POST">
        <input type="hidden" name="book_id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
        
        <label for="book-title">Book Title:</label>
        <input type="text" id="book-title" name="book_title" placeholder="Enter book title" value="<?php echo isset($book_title) ? $book_title : ''; ?>" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" placeholder="Enter author's name" value="<?php echo isset($author) ? $author : ''; ?>" required>

        <label for="publication-year">Publication Year:</label>
        <input type="number" id="publication-year" name="publication_year" placeholder="Enter publication year" value="<?php echo isset($publication_year) ? $publication_year : ''; ?>" required>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN number" value="<?php echo isset($isbn) ? $isbn : ''; ?>" required>

        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit_book' : 'add_book'; ?>" class="submit-btn"><?php echo isset($_GET['edit']) ? 'Update' : 'Add'; ?> Book</button>
    </form>
</div>


    <!-- Display Books -->
    <div class="book-table-section">
        <h2>Available Books</h2>
        <table class="book-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM LibraryBooks";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['Title'] . "</td>
                                <td>" . $row['Author'] . "</td>
                                <td>" . $row['PublicationYear'] . "</td>
                                <td>" . $row['ISBN'] . "</td>
                                <td>
                                    <a href='library_books.php?edit=" . $row['BookID'] . "' class='edit-btn'>Edit</a>
                                    <a href='library_books.php?delete=" . $row['BookID'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No books found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Search Bar Section -->
    <div class="search-section">
        <h2>Search Books</h2>
        <input type="text" id="search-input" placeholder="Search by book title..." class="search-input">
        <button type="button" class="search-btn" onclick="searchBooks()">Search</button>
        <div id="search-results">
            <!-- The search results will be dynamically populated here -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/library_books.js"></script>
