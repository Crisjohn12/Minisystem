<?php
include 'db.php';

$students = loadStudents();

// Handle add student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];

    $id = uniqid(); // Generate a unique ID for the student
    $students[] = ['id' => $id, 'name' => $name, 'age' => $age, 'grade' => $grade];
    saveStudents($students);
}

// Handle delete student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $students = array_filter($students, function($student) use ($id) {
        return $student['id'] !== $id;
    });
    saveStudents($students);
}

// Handle update student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];

    foreach ($students as &$student) {
        if ($student['id'] === $id) {
            $student['name'] = $name;
            $student['age'] = $age;
            $student['grade'] = $grade;
            break;
        }
    }
    saveStudents($students);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Student Dashboard</h1>

    <h2>Add Student</h2>
    <form method="post" action="">
        Name: <input type="text" name="name" required><br>
        Age: <input type="number" name="age" required><br>
        Grade: <input type="text" name="grade" required><br>
        <input type="submit" name="add" value="Add Student">
    </form>

    <h2>Update Student</h2>
    <form method="post" action="">
        ID: <input type="text" name="id" required><br>
        Name: <input type="text" name="name" required><br>
        Age: <input type="number" name="age" required><br>
        Grade: <input type="text" name="grade" required><br>
        <input type="submit" name="update" value="Update Student">
    </form>

    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['id']); ?></td>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['age']); ?></td>
                <td><?php echo htmlspecialchars($student['grade']); ?></td>
                <td>
                    <a href="?delete=<?php echo urlencode($student['id']); ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
