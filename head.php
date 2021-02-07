<?php
if(!isset($_SERVER['HTTPS']) or (isset($_SERVER["HTTPS"]) and $_SERVER['HTTPS'] !== "on")){
    $url = "https://";
    $url.= $_SERVER['HTTP_HOST'];
    $url.= $_SERVER['REQUEST_URI'];
    echo "<meta http-equiv='refresh' content='0; URL=" . $url . "'/>";
}
?>

<meta charset="utf-8">
<title>KGT - Support</title>

<link rel="shortcut icon" type="image/x-icon" href="../data/img/favicon.ico">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="../css/footer.css"/>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link type="text/css" rel="stylesheet" href="../css/style.css">

<?php
include_once "../php/dbh.php";

function getDisplayName($vorname, $nachname){
    if (strlen(strval($vorname)) == 0){
        $name = $nachname;
    }else{
        $name = $vorname . " " . $nachname;
    }
    return $name;
}

function getLoginForm($loginFailed, $attemps = 0, $cookie_user = ""){
    $cookie_value = "";
    if ($cookie_user !== ""){
        $cookie_value = " checked";
    }
    $fehler = "";
    if($loginFailed){
        $fehler = "
        <div class='row'>
            <div class='col s12'>
                <div class='card red white-text'>
                    <div class='card-content'>
                        <span class='card-title'>Falsche Eingabe</span>
                        <p>Dein Benutzername oder dein Passwort ist falsch. Du hast noch " . (5 - $attemps) . " Versuche!</p>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    $html = "
        <form action='login.php' method='post'>
            <input type='hidden' name='page' value='log'>
            <div class='row'>
                <div class='col s12'>
                    <div class='card'>
                        <div class='card-content'>
                            <span class='card-title'><!--Login--></span>
                            <div class='row'> 
                                <div class='col s12'>
                                    <div class='card teal white-text'>
                                        <div class='card-content'>
                                            <span class='card-title'>Hinweis</span>
                                            <p>Der <b>Benutzername</b> für Supporter lautet <b>\"Vorname.Nachname\"</b>.</p>
                                        </div>
                                    </div>
                                </div>                              
                                <div class='input-field col s12 m12 l6'>
                                    <input id='bn' name='user' type='text' class='active' value='" . $cookie_user . "'>
                                    <label for='bn'>Benutzername</label>
                                </div>
                                <div class='input-field col s12 m12 l6'>
                                    <input id='pw' name='pw' type='password' class='active'>
                                    <label for='pw'>Passwort</label>
                                </div>
                                <div class='col s12'>
                                    <p>     
                                        <label>
                                            <input type='checkbox'
                                                   class='filled-in'
                                                   id='filled-in-box'
                                                   name='cookies'" . $cookie_value . "/>
                                            <span class='black-text'>Benutzername speichern (Cookies werden genutzt!)</span>
                                        </label>
                                    </p>
                                </div>
                                
                            </div>
                            <div style='height: 10px'></div>
                            " . $fehler . "
                            <p>Falls du deine Login-Daten vergessen hast, melde dich bei deinem Systemadministrator.</p>
                            
                        </div>
                        <div class='card-action'>
                            <button class='btn teal waves-effect waves-light' type='submit'>Anmelden
                                <i class='material-icons right'>forward</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    ";
    return $html;
}

function getPasswordResetForm($resetFailed, $user = "", $action = "login.php"){
    $fehler = "";
    if($action == "login.php"){
        $titel = "
            <span class='card-title'>Account aktivieren</span>
            <p>Um deinen Support-Account zu aktivieren musst du zuerst ein neues Passwort setzen, dass den Sicherheitskriterien entspricht.</p>
            <br>
            <div class='col s12'>
                <div class='card teal white-text'>
                    <div class='card-content'>
                        <span class='card-title'>Sicherheitskriterien</span>
                        <p>Dein Passwort muss aus <b>mindestens 8 Buchstaben</b> bestehen!<br>Es muss <b>mindestens eine Zahl</b>, <b>ein Großbuchstabe</b> und <b>ein Kleinbuchstabe</b> enthalten.</p>
                    </div>
                </div>
            </div>
        ";
    } else {
        $titel = "
            <!--<span class='card-title'>Passwort zurücksetzen</span>
            <p>Hier kannst du ein neues Passwort setzen, dass den Sicherheitskriterien entspricht.</p>
            <br>-->
            <div class='col s12'>
                <div class='card teal white-text'>
                    <div class='card-content'>
                        <span class='card-title'>Sicherheitskriterien</span>
                        <p>Dein Passwort muss aus <b>mindestens 8 Buchstaben</b> bestehen!<br>Es muss <b>mindestens eine Zahl</b>, <b>ein Großbuchstabe</b> und <b>ein Kleinbuchstabe</b> enthalten.</p>
                    </div>
                </div>
            </div>
        ";
    }
    if($resetFailed == "1"){
        $fehler = "
        <div class='row'>
            <div class='col s12'>
                <div class='card red white-text'>
                    <div class='card-content'>
                        <span class='card-title'>Passwörter inkorrekt</span>
                        <p>Deine beiden Passwörter stimmen nicht überein.</p>
                    </div>
                </div>
            </div>
        </div>
        ";
    }  if($resetFailed == "2"){
        $fehler = "
        <div class='row'>
            <div class='col s12'>
                <div class='card red white-text'>
                    <div class='card-content'>
                        <span class='card-title'>Falsche Eingabe</span>
                        <p>Du kannst dein vorheriges Passwort aus Sicherheitsgründen nicht wiederverwenden.</p>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    $js = "
    <script>
        const m_strUpperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜ';
        const m_strLowerCase = 'abcdefghijklmnopqrstuvwxyzäöüß';
        const m_strNumber = '0123456789';
        const m_strCharacters = '!@#$%^&*?_~.:,;-§/';
    
        function checkPwdStrength() {
            var pw1, pw, pw_len, strength_meter, strength_text, text;
            pw1 = document.getElementById('pw1');
            pw = pw1.value;
            
            pw_len = pw.length;
            
            strength_meter = document.getElementById('strength_meter');
            strength_text = document.getElementById('strength_text');
            
            text = '';
            
            if(pw_len == '0') {
                strength_meter.style.width = '1%';
                text = 'Sehr schwaches Passwort';
                classList_remove_all(strength_meter);
                classList_remove_all(strength_text);
                strength_meter.classList.add('red');
                strength_text.classList.add('red-text');
            } else {
                var scr;
                scr = parseInt(getPwdScore(pw));
                
                strength_meter.style.width = scr + '%';
                
                if(scr >= 90) {
                    text = 'Sehr starkes Passwort';
                    classList_remove_all(strength_meter);
                    classList_remove_all(strength_text);
                    strength_meter.classList.add('green');
                    strength_text.classList.add('green-text');
                }
                else if(scr >= 70) {
                    text = 'Starkes Passwort';
                    classList_remove_all(strength_meter);
                    classList_remove_all(strength_text);
                    strength_meter.classList.add('light-green');
                    strength_text.classList.add('light-green-text');
                }
                else if(scr >= 50) {
                    text = 'Gutes Passwort';
                    classList_remove_all(strength_meter);
                    classList_remove_all(strength_text);
                    strength_meter.classList.add('amber');
                    strength_text.classList.add('amber-text');
                }
                else if(scr >= 30) {
                    text = 'Schwaches Passwort';
                    classList_remove_all(strength_meter);
                    classList_remove_all(strength_text);
                    strength_meter.classList.add('orange');
                    strength_text.classList.add('orange-text');
                }
                else if(scr >= 0) {
                    text = 'Sehr schwaches Passwort';
                    classList_remove_all(strength_meter);
                    classList_remove_all(strength_text);
                    strength_meter.classList.add('red');
                    strength_text.classList.add('red-text');
                }
            }
        
            strength_text.innerHTML = '<b>' + text + '</b>';
        }
        
        function classList_remove_all(e) {            
            e.classList.remove('green');          
            e.classList.remove('light-green');          
            e.classList.remove('amber');          
            e.classList.remove('orange');          
            e.classList.remove('red');            
            e.classList.remove('green-text');          
            e.classList.remove('light-green-text');          
            e.classList.remove('amber-text');          
            e.classList.remove('orange-text');          
            e.classList.remove('red-text');
        }
        
        function getPwdScore(strPassword) {
            // Reset combination count
            var nScore = 0;
        
            // Password length
            // -- Less than 4 characters
            if (strPassword.length < 5) {
                nScore += 0;
            }
            // -- 5 to 7 characters
            else if (strPassword.length > 4 && strPassword.length < 8) {
                nScore += 10;
            }
            // -- 8 or more
            else if (strPassword.length == 8) {
                nScore += 20;
            }
            else if (strPassword.length == 9) {
                nScore += 23;
            }
            else if (strPassword.length == 10) {
                nScore += 26;
            }
            else if (strPassword.length == 11) {
                nScore += 30;
            }
            else if (strPassword.length > 11) {
                nScore += 35;
            }
        
            // Letters
            var nUpperCount = countContain(strPassword, m_strUpperCase);
            var nLowerCount = countContain(strPassword, m_strLowerCase);
            var nLowerUpperCount = nUpperCount + nLowerCount;
            // -- Letters are all lower case
            if (nUpperCount == 0 && nLowerCount != 0) {
                nScore += 5;
            }
            // -- Letters are upper case and lower case
            else if (nUpperCount != 0 && nLowerCount != 0) {
                nScore += 15;
            }
        
            // Numbers
            var nNumberCount = countContain(strPassword, m_strNumber);
            // -- 1 number
            if (nNumberCount == 1) {
                nScore += 10;
            }
            if (nNumberCount == 2) {
                nScore += 15;
            }
            // -- 3 or more numbers
            if (nNumberCount >= 3) {
                nScore += 20;
            }
        
            // Characters
            var nCharacterCount = countContain(strPassword, m_strCharacters);
            // -- 1 character
            if (nCharacterCount == 1) {
                nScore += 5;
            }
            // -- More than 1 character
            if (nCharacterCount == 2) {
                nScore += 10;
            }
            if (nCharacterCount > 2) {
                nScore += 20;
            }
        
            // Bonus
            // -- Letters and numbers
            if (nNumberCount != 0 && nLowerUpperCount != 0) {
                nScore += 2;
            }
            // -- Letters, numbers, and characters
            if (nNumberCount != 0 && nLowerUpperCount != 0 && nCharacterCount != 0) {
                nScore += 3;
            }
            // -- Mixed case letters, numbers, and characters
            if (nNumberCount != 0 && nUpperCount != 0 && nLowerCount != 0
                && nCharacterCount != 0) {
                nScore += 5;
            }
        
            return nScore;
        }
        
        // Checks a string for a list of characters
        function countContain(strPassword, strCheck) {
            // Declare variables
            var nCount = 0;
        
            for (i = 0; i < strPassword.length; i++) {
                if (strCheck.indexOf(strPassword.charAt(i)) > -1) {
                    nCount++;
                }
            }
        
            return nCount;
        }
    </script>
    ";
    $html = $js . "
    <form action='" . $action . "' method='post'>
        <input type='hidden' name='page' value='log'>
        <input type='hidden' name='user' value='" . $user ."'>
        <div class='row'>
            <div class='col s12'>
                <div class='card'>
                    <div class='card-content'>
                        " . $titel . "
                        <div class='row'>
                            <div class='input-field col s12 m12 l6'>
                                <input id='pw1' name='pw1' type='password' class='validate' required pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{7,})\S$' onkeyup='return checkPwdStrength();'>
                                <label for='pw1'>Passwort</label>
                            </div>
                            <div class='input-field col s12 m12 l6'>
                                <input id='pw2' name='pw2' type='password' class='validate' required pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{7,})\S$'>
                                <label for='pw2'>Passwort wiederholen</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col s12'>
                                <div class='progress'>
                                    <div id='strength_meter' class='determinate red' style='width: 1%'></div>
                                </div>
                            </div>
                            <div class='col s12'>
                                <p id='strength_text' class='red-text'><b>Schwaches Passwort</b></p>
                            </div>
                        </div>
                            
                        " . $fehler . "
                    </div>
                    <div class='card-action'>
                        <button class='btn teal waves-effect waves-light' type='submit'>Speichern
                            <i class='material-icons right'>save</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    ";
    return $html;
}

function generateToken(){
    $token = tokenGenerator();
    $sql = "SELECT token FROM support_kgt_tokens WHERE token = '" . $token . "'";
    while($tokenRow = mysqli_fetch_assoc(mysqli_query($con,$sql))){
        $token = getToken();
        $sql = "SELECT token FROM support_kgt_tokens WHERE token = '" . $token . "'";
    }
    return $token;
}

function tokenGenerator(){
    $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    $token = "";
    $token = $token . substr($chars,rand(0,33),1);
    $token = $token . substr($chars,rand(0,33),1);
    $token = $token . substr($chars,rand(0,33),1);
    $token = $token . "-";
    $token = $token . substr($chars,rand(0,33),1);
    $token = $token . substr($chars,rand(0,33),1);
    $token = $token . substr($chars,rand(0,33),1);

    return $token;
}

?>
