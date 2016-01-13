<html>
<head>
    <title>JnU</title>
    <meta charset="utf-8">
    <link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="javascripts/jquery.min.js"></script>
    <script type="text/javascript" src="javascripts/script.js"></script>
    <script src="javascripts/jquery-1.10.2.js"></script>
    <script src="javascripts/jquery-ui.js"></script>   
    <script>
    $(function() {
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();
    });
    </script>
</head>
<body>
  <script>
  $(function(){
      // this will get the full URL at the address bar
      var url = window.location.href;
      if(url=="http://localhost/mms/")
      {
        url+="index.php";
      }
      // passes on every "a" tag
      $(".menu-bar a").each(function() {
              // checks if its the same on the address bar
          //window.alert(this.href);
          if(url == (this.href)) {
              $(this).closest("li").addClass("active");
          }
      });
  });
  </script>
<div class="banner">
    <h1 class="hero-item">Migration Management System</h1>
    <div class="menu">
      <ul class="menu-bar">
        <li class="menu-item"><a href="index.php">Home</a></li>
        <li class="menu-item"><a href="notice.php">Notice Board</a></li>
        <?php
          if(isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']))
          {
            ?>
              <li class="menu-item"><a href="profile.php">Profile</a></li>
              <li class="menu-item"><a href="logout.php">Log Out</a></li>
            <?php
          }
          elseif(!isset($_SESSION['user_id']) && isset($_SESSION['admin_id']))
          {
            ?>
              <li class="menu-item"><a href="add_subject.php">Add Subject</a></li>
              <li class="menu-item"><a href="add_marks.php">Add Marks</a></li>
              <li class="menu-item"><a href="trigger.php">Trigger Events</a></li>
              <li class="menu-item"><a href="logout.php">Log Out</a></li>
            <?php
          }
          else
          {
            ?>
              <li class="menu-item"><a href="signup.php">Sign Up</a></li>
              <li class="menu-item"><a href="login.php">Log In</a></li>
            <?php
          }
        ?>
      </ul>
    </div>
</div>
