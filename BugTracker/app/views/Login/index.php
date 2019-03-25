<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="/BugTracker/css/login-layout.css">

  
</head>

<body>

  <div class="login-container">
  <section class="login" id="login">
    <header>
      <h2>Bug Tracker</h2>
      <h4>Login</h4>
    </header>
    <form class="login-form" id="user-form" action="/login/start_session" method="post">
      <span id="error-msg"> </span>
      <input type="text" class="login-input" id="uid" placeholder="Username" required autofocus/>
      <input type="password" class="login-input" id="pwd" placeholder="Password" required/>
      <div class="submit-container">
        <button type="submit" name="login" class="login-button">SIGN IN</button>
      </div>
    </form>
  </section>
</div>

<script src="/BugTracker/js/jquery-1.11.1.min.js"></script>
<script  src="/BugTracker/js/login.js"></script>

</body>

</html>
