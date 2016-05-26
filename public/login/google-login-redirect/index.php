<?php

session_start(); //session start
if (!isset($_SESSION['user_data'])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/set_env_variables.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/../vendor/google/apiclient/src/Google/autoload.php';
//require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
//require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/debugger.php';
//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
    $client_id = getenv("CUSTOMCONNSTR_GSDKclientid");
    $client_secret = getenv("CUSTOMCONNSTR_GSDKclientsecret");
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/login/google-login-redirect/';

//incase of logout request, just unset the session var
    if (isset($_GET['logout'])) {
        unset($_SESSION['access_token']);
    }

    /*     * **********************************************
      Make an API request on behalf of a user. In
      this case we need to have a valid OAuth 2.0
      token for the user, so we need to send them
      through a login flow. To do this we need some
      information from our API console project.
     * ********************************************** */
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("email");
//$client->addScope("profile");

    /*     * **********************************************
      When we create the service here, we pass the
      client to it. The client then queries the service
      for the required scopes, and uses that when
      generating the authentication URL later.
     * ********************************************** */
    $service = new Google_Service_Oauth2($client);

    /*     * **********************************************
      If we have a code back from the OAuth 2.0 flow,
      we need to exchange that with the authenticate()
      function. We store the resultant access token
      bundle in the session, and redirect to ourself.
     */
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;
    }

    /*     * **********************************************
      If we have an access token, we can make
      requests, else we generate an authentication URL.
     * ********************************************** */
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);
    } else {
        $authUrl = $client->createAuthUrl();
    }


//Display user info or display login url as per the info we have.
    echo '<div style="margin:2%;font-family:arial " >';
    if (isset($authUrl)) {
        //user not logged in: this is code for button to let user login
        echo '<div align="center">';
        echo '<h1>Login with Google</h1>';
        echo '<div><h3>Please click the Sign in button</h3></div>';
        echo '<div style=" position: absolute;top: 50%;left: 50%;transform: translateX(-50%) translateY(-50%);"><a class="login" href="' . $authUrl . '"><button style="background:none"><img src="btn_google_signin_light_pressed_web@2x.png" /></button></a></div>';
        echo '</div>';
    } else {
// user is already logged in. fetch info from the google api and check if the user is from bits
        $user = $service->userinfo->get(); 
        if (substr($user['email'], -24) !== "@dubai.bits-pilani.ac.in") {
            $actual_link = "http://{$_SERVER['HTTP_HOST']}/login/logout.php";
            echo '<script>console.log("' . $actual_link . '")</script>';
            echo '<b>' . $user['email'] . '</b>'
            . ' <span style="color:red;">is not affliated to BITS PILANI Dubai'
            . '<br>as it isn\'t part of domain @dubai.bits-pilani.ac.in . Please '
            . '<br>login with account of form</span> <b> *******@dubai.bits-pilani.ac.in</b>'
            . '<br><a href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . $actual_link . '"">'
            . '<br>Click to Logout and Sing In with BITS Pilani Dubai account</a>';
            die();
        } else {
            $userId = substr($user['email'], 0, -24);
            echo 'valid login for ' . $userId;
            echo 'Signing you in';
            require_once $_SERVER["DOCUMENT_ROOT"] . '/../tools/auth_manager.php';
            $auth_manager = new auth_manager();
            $auth_manager->set_session($user['email']);
            var_dump($_SESSION['user_data']);
            //remeber session is not reset here. Only user_data is set 
            echo '<br><a href="../logout.php">LOGOUT</a>';
            go_to_home();
        }
    }
    echo '</div>';
} else {
    echo 'Already signed into portal. ';
    go_to_home();
    echo '<br><a href="../logout.php">LOGOUT</a>';
}

function go_to_home() {
    switch ($_SESSION['user_data']['type']) {
        case 'faculty':
            echo '<script>location.href="/faculty/index.php"</script>';
            break;
        case 'student':
            echo '<script>location.href="/student/index.php"</script>';
            break;
        default:
            break;
    }
}