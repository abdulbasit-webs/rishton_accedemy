<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Linking the main CSS file -->
    <link rel="stylesheet" href="css/styles.css">
    
    <title>Rishton Academy</title>
</head>
<body>
    <!-- Header Section -->
    <header class="site-header">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">Rishton Academy</a> <!-- Logo linking to the home page -->
            </div>
            <!-- Mobile Menu Toggle (Hamburger Icon) -->
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <!-- Navigation Links -->
            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="classes.php">Classes</a></li>
                <li><a href="pupils.php">Pupils</a></li>
                <li><a href="teachers.php">Teachers</a></li>
                <li><a href="parents.php">Parents</a></li>
                <li><a href="salaries.php">Salaries</a></li>
                <li><a href="library_books.php">Library</a></li>
                <!-- Additional Section with Nested Menu -->
                <li class="dropdown">
                    <a href="#" class="dropbtn">Additional</a>
                    <ul class="dropdown-content">
                        <li><a href="teaching_assistant.php">Teaching Assistant</a></li>
                        <li><a href="diners_money.php">Diners Money</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <!-- End of Header Section -->

    <!-- Include JavaScript -->
    <script src="js/scripts.js"></script>
</body>
</html>
