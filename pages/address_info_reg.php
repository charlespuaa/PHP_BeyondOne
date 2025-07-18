<?php
include 'header.php';

$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$email = $_POST['email'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';

$street_name = $_POST['street_name'] ?? '';
$house_number = $_POST['house_number'] ?? '';
$building = $_POST['building'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';
$barangay = $_POST['barangay'] ?? '';
$province = $_POST['province'] ?? '';
$city = $_POST['city'] ?? '';
$region = $_POST['region'] ?? '';
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

        input[type="text"] {
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
            input[type="text"] { 
            font-size: 0.95rem; 
            padding: 8px; 
        }

        }
    </style>
</head>
<body>

<h1>Registration</h1>
<form method="post" action="account_info_reg.php">
    <fieldset>
        <legend>Address Information</legend>

        <label>Street Name</label>
        <input type="text" name="street_name" required value="<?= htmlspecialchars($street_name) ?>">

        <label>House Number</label>
        <input type="text" name="house_number" required value="<?= htmlspecialchars($house_number) ?>">

        <label>Building (Optional)</label>
        <input type="text" name="building" value="<?= htmlspecialchars($building) ?>">

        <label>Postal Code</label>
        <input type="text" name="postal_code" required pattern="[1-9][0-9]{3}" value="<?= htmlspecialchars($postal_code) ?>">

        <label>Barangay</label>
        <input type="text" name="barangay" required value="<?= htmlspecialchars($barangay) ?>">

        <label>Province</label>
        <input type="text" name="province" required value="<?= htmlspecialchars($province) ?>">

        <label>City</label>
        <input type="text" name="city" required value="<?= htmlspecialchars($city) ?>">

        <label>Region</label>
        <input type="text" name="region" required value="<?= htmlspecialchars($region) ?>">

        <!-- Hidden carry-overs -->
        <input type="hidden" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
        <input type="hidden" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">
        <input type="hidden" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
        <input type="hidden" name="birthday" value="<?= htmlspecialchars($birthday) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="contact_number" value="<?= htmlspecialchars($contact_number) ?>">

        <input type="submit" value="Next">
    </fieldset>
</form>
</body>
</html>
