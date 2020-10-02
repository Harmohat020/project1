<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Vergeten</title>
    <!--Custom Styles -->
    <link rel="stylesheet" href="assets/styles/style.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <div class="form-box">
        <form class="form form-login" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-title">
              <h1>Wachtwoord vergeten</h1>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"  placeholder="name@example.com" required />
            </div>
            <div class="form-btn-submit-box">
                <input type="bevestigen" class="btn btn-primary btn-submit" value="Bevestigen"/>
            </div>
        </form>
    </div>
</body>
</html>