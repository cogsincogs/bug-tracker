<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
<div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="signup-logic.php" class="contact" method="post">
            <div class="form-group">
                <input type="text" name="username" id="username" placeholder="Username">
            </div>    
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
            <p>Already have an account? <a href="/login/">Login here</a>.</p>
        </form>
    </div>
</body>
</html>