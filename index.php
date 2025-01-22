<?php 

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Login</title>

    <style>
      * {
        box-sizing: border-box;
        padding: 0px;
        margin: 0;
      }
      .container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        width: 100%;
        flex-flow: column;
      }
      h2 {
        text-align: center;
        margin-bottom: 20px;
      }
      form {
        box-shadow: 1px 1px 6px #0008;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-flow: column;
        overflow: hidden;
      }
      form label {
        padding: 20px;
        margin: 15px auto;
        text-align: center;
        border: 1px dashed #000;
        position: relative;
        cursor: pointer;
      }
      form label input {
        height: 50px;
        width: 100%;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
      }
      form label img {
        height: auto;
        display: block;
        margin: auto;
        max-width: 150px;
      }
      form button {
        padding: 5px 15px;
        color: #fff;
        font-size: 16px;
        line-height: 24px;
        outline: none;
        border-color: transparent;
        cursor: pointer;
        border-radius: 5px;
        background: #0087ff;
        position: relative;
        transition: all 0.5s;
      }
    </style>
  </head>
  <body>


<?php

if($_SESSION["login"] == "verified"){
    adminpanel();
}

else{
    
    login();

    echo '    <script>
    let key = document.querySelector("#key");
    let value = document.querySelector("#data");
    let button = document.querySelector("form button");

    key.addEventListener("change", () => {
      value.innerText = "";

      let url = URL.createObjectURL(key.files[0]);

      let img = document.createElement("img");

      img.src = url;

      value.append(img);
    });
  </script>';

}


if(isset($_POST['login'])){

    $key = $_FILES['key'];

    $pass = file_get_contents("password/pass.png");

    $keyvalue = file_get_contents($key["tmp_name"]);

    echo base64_encode($pass) ."<hr>";

    echo base64_encode($key) . "<hr>";


     if(base64_encode($pass) == base64_encode($keyvalue)){

        $_SESSION["login"] = "verified";

        echo '<script>alert("Logged In Successfully"); 
        location.replace(document.referrer);</script>';

     }
    
     else{
        $_SESSION["login"] = "";
        echo '<script>alert("Wrong Key"); 
        location.replace(document.referrer);</script>';
     }
}


function login(){
    echo '   <div class="container">
    <h2>Login</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <label>
        <span id="data"> Drop or Choose Passkey</span>
        <input type="file" name="key" id="key" accept="image/*" />
      </label>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
';
}


function adminpanel(){
    echo '   <div class="container">
    <h2>Welcome To Admin</h2>
    <form action="" method="post">
      <button type="submit" name="logout">Logout</button>
    </form>
  </div>
';
}

if(isset($_POST['logout'])){
    session_destroy();
    echo '<script>alert("Logout Successfully"); 
    location.replace(document.referrer);</script>';
}






?>


  </body>
</html>
