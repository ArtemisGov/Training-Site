<html>
<head>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
  <title>
    Login
  </title>
<style>
html, body {
  margin: 0px;
  background-color:  #F5F5F5;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: white;
  position: fixed;
  z-index: 2;
  top: 0;
  width: 100vw;
}
li {
  float: right;
}
li a {
  display: block;
  color: black;
  text-align: center;
  padding: 25px 16px;
  text-decoration: none;
  font-size: 19px;
}
#login {
  max-width: 500px;
  background-color: white;
  padding: 20px;
  position: relative;
  height: 500px;
}
#login #loginFooter {
  position: absolute;
  bottom: 2;
  left: 0;
  float: left;
  margin-left: 20px;
}
label {
  float: left;
  margin-top: 2px;
}
</style>
<script>
$(document).ready(function() {
    $('#menu').load('menu.html');
});
</script>
</head>
<body>
  <span id="menu">

  </span>
<br /><br /><br /><br /><br /><br />
<center>
  <div id="login">
    <br />
    <h3> Login </h3>
    <form action="/action_page.php">
      <br />
        <label> Username </label> <input type="text" class='form-control' name="fname"><br />
        <label> Password </label> <input type="password" class='form-control' name="password"><br />
        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
    <span id="loginFooter">
      <a href="register.php">
         Register
      </a>
    </span>
  </div>
</center>
</body>
</html>
