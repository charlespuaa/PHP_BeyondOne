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
        padding-top: 170px; 
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #E6BD37;
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

    input[type="text"], input[type="date"], input[type="password"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background: #F9F9F9;
        box-sizing: border-box;
    }

    input[type="submit"], .signin-button {
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

    input[type="submit"]:hover, .signin-button:hover {
        background: #fff;
        color: #E6BD37;
        border: 2px solid #E6BD37;
    }

    .success, .error-text {
        text-align: center;
        padding: 5px;
        margin-top: 10px;
        font-size: 14px;
    }

    .success { color: green; }
    .error-text { color: red; }

    .back-container {
        max-width: 500px;
        margin: 20px auto;
        padding: 15px;
        border: 2px solid #E6BD37;
        border-radius: 10px;
        text-align: center;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .back-container:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
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

        input[type="submit"], .signin-button {
            font-size: 0.95rem;
            padding: 10px;
        }

        label {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        body {
            padding-top: 110px; 
        }

        h1 {
            font-size: 1.3rem;
        }

        input[type="text"], input[type="date"], input[type="password"] {
            font-size: 0.95rem;
            padding: 8px;
        }

        input[type="submit"], .signin-button {
            font-size: 0.9rem;
            padding: 8px 16px;
        }
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
