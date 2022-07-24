<?php
// I used basic codding style in order to help those begginer programmers to understand how php works in the html
// need 4 parameters(type of host, username of the server , password, database)
$conn = mysqli_connect('localhost', 'Zylle','test1234','sign_and_login');

if($conn){
  echo 'SERVER CONNECTED';
}
else{
  echo 'SERVER IS NOT CONNECTED';
}

$make_sql = 'SELECT id,User_data,Pass_data FROM sign_login_table ORDER BY time_data';
$create_sql = mysqli_query($conn, $make_sql);
$fetch_data = mysqli_fetch_all($create_sql, MYSQLI_ASSOC);
// print_r($fetch_data);  //remove the comments to see the data in real time 

$pass_data = $user_data = '';
$error_catch = ['User_err'=> '', 'Pass_err'=> ''];
if(isset($_POST['btn_submit'])){
  // create a parameters to avoid empty string and recieve a desire characters on the input

  if(empty($_POST['input_user'])){
    $error_catch['User_err'] = 'There is no element in the username';
  }
  else{
     $user_data = $_POST['input_user'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $user_data)){
      $error_catch['User_err'] = 'Please do not use non letter character';
    }
  }
  if(empty($_POST['input_pass'])){
    $error_catch['Pass_err'] = 'There is no element in the password';
  }
  else{
    $pass_data = $_POST['input_pass'];
    if(!strlen($pass_data) >= 8){
      $error_catch['Pass_err'] = 'The characters must be 8 or above';
      
    }
  }
  if(array_filter($error_catch)){
    
  }
  else{
    
  $pass_data = mysqli_real_escape_string($conn, $_POST['input_pass']); 
  $user_data =  mysqli_real_escape_string($conn, $_POST['input_user']);
  
  $data_injection = "INSERT INTO sign_login_table(User_data,Pass_data) VALUES('$user_data','$pass_data')";
  
  // checking if the the condition has been met and the connection is still on
  if(mysqli_query($conn,$data_injection)){
    header('Location: SignUpmess.php');
  }
  else{
    echo 'there is no connection';
  }

  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <link type="text/css" rel="stylesheet" href="stylefs.css" />
    <title>Main</title>
  </head>
  <body>

  
    <section class="hero is-success is-fullheight">
      <div class="hero-head"></div>
      <div class="hero-body">
        <div class="container">
          <div class="columns is-centered has-background-black">
            <div class="column is-4">
              <div class="has-text-centered">
                <h1 class="title is-size-1 has-text-white">Sign Up</h1>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method = 'POST'>
                  <div class="field">
                    <label class="label has-text-left has-text-white"
                      >Username</label
                    >
                    <div class="control">
                      <input
                        class="input"
                        type="text"
                        placeholder="e.g Zillenzer"
                        name = 'input_user'
                        value = '<?php echo $user_data ;?>'
                      />
                    </div>
                  </div>
                  <p class="has-tex-white subtitle is-size-4">
                    <?php echo $error_catch['User_err'] ?>
                  </p>

                  <div class="field">
                    <label class="label has-text-left has-text-white"
                      >Password</label
                    >
                    <div class="control">
                      <input
                        class="input"
                        type="text"
                        placeholder="e.g. 1FE2U348*73 "
                        name = 'input_pass'
                        value = '<?php echo $pass_data; ?>' 
                      />
                    </div>
                  </div>
                  <p class="has-tex-white subtitle is-size-4">
                    <?php echo $error_catch['Pass_err']; ?>
                  </p>
                  <div class="control my-4">
                    <input
                      type="submit"
                      value="SUBMIT"
                      class="btn_tar button"
                      name = 'btn_submit'
                    />
                  </div>
                  <a href="login.php" class="li-tar">
                    have already an account??</a
                  >
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-foot"></div>
    </section>
  </body>
</html>
