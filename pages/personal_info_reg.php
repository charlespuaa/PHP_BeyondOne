<?php include 'header.php'; ?>
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
        fieldset {
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            background: #F9F9F9;
            max-width: 500px;
            margin: auto;
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
            color: #000;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #d9aa2f;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Registration</h1>
<form method="post" action="address_info_reg.php">
    <fieldset>
        <legend>Personal Information</legend>
        <label>First Name</label>
        <input type="text" name="first_name" pattern="[A-Za-z\s]+" required>

        <label>Middle Name (Optional)</label>
        <input type="text" name="middle_name" pattern="[A-Za-z\s]*">

        <label>Last Name</label>
        <input type="text" name="last_name" pattern="[A-Za-z\s]+" required>

        <label>Birthday</label>
        <input type="date" name="birthday" required>

        <label>Email</label>
        <input type="text" name="email" pattern="^[A-Za-z]+[A-Za-z0-9._]*@[A-Za-z0-9]+\.[A-Za-z]{2,}$" required>

        <label>Contact Number</label>
        <input type="text" name="contact_number" pattern="^09[0-9]{9}$" required>

        <input type="submit" value="Next">
    </fieldset>
</form>

</body>
</html>
