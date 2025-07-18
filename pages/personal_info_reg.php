<?php


$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$email = $_POST['email'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            padding: 20px;
            padding-top: 170px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        fieldset {
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            background: #F9F9F9;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        legend {
            font-weight: bold;
            color: #E6BD37;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #E6BD37;
            color: #fff;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #fff;
            color: #E6BD37;
            border: 2px solid #E6BD37;
        }
        /* responsiveness across devices */
        @media (max-width: 768px) {
            body { 
            padding-top: 130px; 
            padding-left: 10px; 
            padding-right: 10px; 
        }
            h1 { 
            font-size: 1.6rem;
        }
            input[type="submit"] { 
            font-size: 0.95rem; 
            padding: 10px; 
        }
            label { 
            font-size: 0.9rem; 
        }

        }

        @media (max-width: 480px) {
            h1 { 
            font-size: 1.3rem; 
        }
            input[type="text"], input[type="date"] { 
            font-size: 0.95rem; 
            padding: 8px; 
        }
        
        }
    </style>
    <?php include 'header.php'; ?>
 </head>
<body>
<h1>Registration</h1>
<form method="post" action="address_info_reg.php">
    <fieldset>
        <legend>Personal Information</legend>

        <label>First Name</label>
        <input type="text" name="first_name" required value="<?= htmlspecialchars($first_name) ?>">

        <label>Middle Name</label>
        <input type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">

        <label>Last Name</label>
        <input type="text" name="last_name" required value="<?= htmlspecialchars($last_name) ?>">

        <label>Birthday</label>
        <input type="date" name="birthday" required value="<?= htmlspecialchars($birthday) ?>">

        <label>Email</label>
        <input type="text" name="email" required value="<?= htmlspecialchars($email) ?>">

        <label>Contact Number</label>
        <input type="text" name="contact_number" required value="<?= htmlspecialchars($contact_number) ?>">

        <input type="submit" value="Next">
    </fieldset>
</form>
</body>
</html>
