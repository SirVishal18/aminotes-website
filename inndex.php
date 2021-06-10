<?php
 
session_start();
 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        ?>
        <script>
            alert("Please type in a name");
        </script>
        <?php
    }
}
if (!isset($_SESSION['name']))
{
    $session_name = "False";    
}else{
    $session_name = "True";
}
function loginForm(){
    echo
    '<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
      <label for="name">Name </label>
      <input type="text" name="name" id="name" />
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="It was never droped someone created it😁😂😅">
  <meta name="author" content="Sarvesh Mishra">

  <title>Amity Notes</title>
  <link href="/ico/main-ico.png" rel="icon" type="image/x-icon">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!--icons-->
  <link rel="stylesheet" href="  https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <!--russo one-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@900&display=swap" rel="stylesheet">

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Custom styles for this site -->
  <link href="css/landing-page.css" rel="stylesheet">


  <link href="style.css" rel="stylesheet">
    </script>
    <script>
    function chatfun() {
        if (document.getElementById("outer").style.display == "none") {
            var session_name = "<?php echo $session_name;?>";
            console.log(session_name)
            if (session_name == "True"){
                document.getElementById("outer").style.display = "block";
            }else{
                if (document.getElementById("loginform").style.display == "none") {
                    document.getElementById("loginform").style.display = "block";
                }else{
                    document.getElementById("loginform").style.display = "none";
                }
            }
        }
        else{
            document.getElementById("outer").style.display = "none";
        }
        
    }
    </script>

    <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 50; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 50; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2500);
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>

</head>

<body>
<button class="open-button" onclick="chatfun()"><i class="fas fa-comment-dots"></i><button>
<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
        <label for="name">Name </label>
        <input type="text" name="name" id="name" />
        <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
</div>
<div id="outer" style="<?php echo 'display:none' ?>">
    <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        </div>

        <div id="chatbox">
        <?php
        if(file_exists("log.html") && filesize("log.html") > 0){
            $contents = file_get_contents("log.html");          
            echo $contents;
        }
        ?>
        </div>
 
        <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" />
        <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
    </form>
</div>
  <!-- Navigation -->
  <?php
    require ('./assest/header.php');
  ?>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Welcome to AmiNotes</h1>
          <a href="#features">
            <svg class="arrows">
              <path class="a1" d="M0 0 L30 32 L60 0"></path>
              <path class="a2" d="M0 20 L30 52 L60 20"></path>
              <path class="a3" d="M0 40 L30 72 L60 40"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons text-center features" id="features">
    <div class="container-fluid">
      <div class="row">
        <div class=col-lg-12>
          <div class="row no-gutters mb-5">

            <div class="col-lg-12 col-sm-12 order-lg-1 my-auto features-text pt-4 px-o pb-0">
              <p class="sec-tit-p">Features</p>
            </div>

          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fas fa-desktop m-auto text-primary"></i>
            </div>
            <h3><a href="./notes/" style="text-decoration:none;color:#212529;">All Notes</a></h3>
            <p class="lead mb-0">You will get all notes on your device<br>It's that easy!</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fas fa-layer-group m-auto text-primary"></i>
            </div>
            <h3>Category</h3>
            <p class="lead mb-0">Every note is categorised and shorted in a perfect way.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="far fa-check-circle m-auto text-primary"></i>
            </div>
            <h3>Easy to use</h3>
            <p class="lead mb-0">Simplest User-Interface just for you!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Department -->
  <section class="text-center showcase">
    <div class="container-fluid p-0">
      <div class="row no-gutters">

        <div class="col-lg-12 col-sm-12 order-lg-1 my-auto showcase-text pt-4 px-o pb-0">
          <p class="sec-tit-p">Departments</p>
        </div>

      </div>
      <div class="row no-gutters">

        <div class="col-lg-12 order-lg-1 my-auto showcase-text">
          <h3>AIIT</h3>
          <p class="lead mb-0">Bsc IT , Msc IT<br>BCA and MCA</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials text-center">
    <div class="container">
      <h2 class="mb-5">HOD</h2>
      <div class="row">
        <div class="col-lg-12">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/Di-ck.jpg" alt="Dr. Ajay Ranas">
            <h5>Dr. Ajay Rana</h5>
            <p class="font-weight-light mb-0">Director - AIIT<br>Amity University<br>Noida</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a
                href="mailto:vishal.shuklaji45@gmail.com?subject=Feedback/Help and support&body=There you can type your query">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Cookies</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Copyright 2021 All Rights Reserved by Vishal Shukla.
          </p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="https://twitter.com/Vishal_Shukla_?s=09" target="_blank">
                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/invites/contact/?i=1nnr3tkyu8ij&utm_content=47u2s80" target="_blank">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="https://discord.gg/2WQZmzN9jF" target="_blank">
                <i class="fab fa-discord fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
</body>

</html>
