<?php
include 'header.php';
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
        padding-top: 200px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #E6BD37; /* gold title */
    }

    fieldset {
        border: 2px solid #E6BD37;
        border-radius: 10px;
        padding: 20px;
        background: #fff;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    fieldset:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
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
        background: #F9F9F9;
        box-sizing: border-box;
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
        transition: background 0.3s, color 0.3s, border 0.3s;
    }

    input[type="submit"]:hover {
        background: #fff;
        color: #E6BD37;
        border: 2px solid #E6BD37;
    }
</style>

</head>
<body>

<h1 style="text-align:center;">Registration</h1>
<form method="post" action="account_info_reg.php">
    <fieldset>
        <legend>Address Information</legend>
        <label>Street Name</label>
        <input type="text" name="street_name" required>

        <label>House Number</label>
        <input type="text" name="house_number" required>

        <label>Building (Optional)</label>
        <input type="text" name="building">

        <label>Postal Code</label>
        <input type="text" name="postal_code" pattern="[1-9][0-9]{3}" required>

        <label>Barangay</label>
        <input type="text" name="barangay" required>

        <label>Province</label>
        <input type="text" name="province" required>

        <label>City</label>
        <input type="text" name="city" required>

        <label>Region</label>
        <input type="text" name="region" required>

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
