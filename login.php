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
//print_r($fetch_data);  //remove the comments to see the data in real time 

$pass_data = $user_data = $login_err = '';
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
   
    $user_appr = $_POST['input_user'];
    $pass_appr = $_POST['input_pass'];
    //create some default values to be overwriten when the condition has been met
    $count = 0;
    $user_id = -1;
    $pass_id = -2;
  
    foreach($fetch_data as $userdata){
        
        if($user_appr == $userdata['User_data']){
            echo '<br>.   FILE HAD FOUND  . <br>';
           
           $user_id = $count;
           echo '<br>'.  $user_id .'<br>';
          
           
        }
       
        if($pass_appr == $userdata['Pass_data']){
            echo '<br>.   FILE HAD FOUND  . <br>';
            
            $pass_id = $count;
            echo '<br>'.  $pass_id .'<br>';
           
        }
       
    
        $count = $count + 1;
      
        

    }
    // creating a condition that will check if they are the same ID in the database table
    if($user_id == $pass_id ){
     header('Location:acct_varified.php');
     

     
    }
    else{
       $login_err = 'Please check again if the username and password is correct';
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
    <title>Login Page</title>
  </head>
  <body>
    
    <section class="hero is-success is-fullheight">
      <div class="hero-head"></div>
      <div class="hero-body">
        <div class="container">
          <div class="columns is-centered has-background-black">
            <div class="column is-4">
              <div class="has-text-centered">
                <h1 class="title is-size-1 has-text-white">Login</h1>
                <form action="<?php $_SERVER['PHP_SELF']?>" method ='POST'>
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
                  <p><?php echo $login_err; ?></p>
                  <div class="control my-4">
                    <input
                      type="submit"
                      value="SUBMIT"
                      class="btn_tar button"
                      name = 'btn_submit'
                    />
                  </div>
                  <a href="SignUp_page.php" class="li-tar">
                    Don't have an account??</a
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
