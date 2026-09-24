<?php

require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $course = $_POST["course"];
    $specialization = $_POST["specialization"];
    $skills = $_POST["skills"] ?? [];
    $address = $_POST["address"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $pincode = $_POST["pincode"];
    $preferred_date = $_POST["preferred_date"];
    $preferred_time = $_POST["preferred_time"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check passwords
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Convert skills array into string
    $skillsString = implode(", ", $skills);

    // Insert data
    $sql = "INSERT INTO students
            (name, email, phone, gender, dob, course, specialization,
             skills, address, state, city, pincode,
             preferred_date, preferred_time, password)
            VALUES
            (:name, :email, :phone, :gender, :dob, :course, :specialization,
             :skills, :address, :state, :city, :pincode,
             :preferred_date, :preferred_time, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":gender" => $gender,
        ":dob" => $dob,
        ":course" => $course,
        ":specialization" => $specialization,
        ":skills" => $skillsString,
        ":address" => $address,
        ":state" => $state,
        ":city" => $city,
        ":pincode" => $pincode,
        ":preferred_date" => $preferred_date,
        ":preferred_time" => $preferred_time,
        ":password" => $hashedPassword
    ]);

    echo "<h1>Registration Successful!</h1>";
    echo "<p>Student has been saved to the database.</p>";
}

?>