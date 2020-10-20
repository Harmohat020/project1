<?php
class DB{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;
    private $pdo;

    public function __construct($host, $user, $pass, $db, $charset){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->charset = $charset; 
        
        try{
            $dsn = 'mysql:host='. $this->host.';dbname='.$this->db.';charset='.$this->charset;
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
        catch(\PDOException $e){
            echo "Connection Failed: ".$e->getMessage();
        }
      
    }

    public function register_insert($voornaam, $tussenvoegsel, $achternaam, $email, $pwd, $username){ 
        try {  
                /* Begin a transaction, turning off autocommit */
                $this->pdo->beginTransaction();

                //username & email check if exists
                $sqlCheckUser = "SELECT email, gebruikersnaam FROM account";

                $queryCheckUser = $this->pdo->prepare($sqlCheckUser);

                $queryCheckUser->execute();

                // is an associative array 
                $resultCheckUser = $queryCheckUser->fetchAll(PDO::FETCH_OBJ);
                
                $emailChecker = [];
                $usernameChecker  = [];

                foreach ($resultCheckUser as $checkUser) {
                    array_push($emailChecker, $checkUser->email);
                    array_push($usernameChecker, $checkUser->gebruikersnaam);
                }
                
                /* Check if Email and Username already exists in database */
                if (in_array($email, $emailChecker) AND in_array($username, $usernameChecker)) {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Email & Username Already Exists' .'</div>';    
                }
                /* Check if Email already exists in database */
                elseif(in_array($email, $emailChecker)) {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Email Already Exists' .'</div>';    
                }
                /* Check if Username already exists in database */
                elseif(in_array($username, $usernameChecker)){
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Username Already exists' .'</div>';    
                }
                /* If Email and Username doesn't exists in database, data will be put into the database*/
                else{
                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);  

                    $sql = "INSERT INTO account(ID, email, password, gebruikersnaam, usertype_id)
                    VALUES(NULL, '$email', '$pwd', '$username', 4);";
                    
                    /*will return the same PDOStatement, without any data attached to it. 
                    Prepares a statement for execution and returns a statement object */ 
                    $myQuery = $this->pdo->prepare($sql);
                    
                    /* Executes the prepared statement */
                    $myQuery->execute();
                    
                    /* Getting the last inserted ID value */
                    $ID = $this->pdo->lastInsertId();
                    
                    $sql2 = "INSERT INTO persoon(ID, voornaam, tussenvoegsel, achternaam, account_id)
                    VALUES(NULL, '$voornaam', '$tussenvoegsel', '$achternaam', '$ID');";
                    
                    /*will return the same PDOStatement, without any data attached to it. 
                    Prepares a statement for execution and returns a statement object*/    
                    $myQuery = $this->pdo->prepare($sql2);
                    
                    /* Executes the prepared statement */
                    $myQuery->execute();
    
                    /* Commit the changes */
                    $this->pdo->commit();

                    error_log('✓ - Registration Success: username: '.$username.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/register/log_'.date("d-m-Y").'.log');
                                    
                    /* Prevents that data is always added to the table during refresh */
                    header("Location: index.php");
                }
                
        } 
        catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    
              
    }

    public function login($username, $pwd){ 
        try {  
                /* Begin a transaction, turning off autocommit */
                $this->pdo->beginTransaction(); 

                $sql = "SELECT voornaam, tussenvoegsel, achternaam, email, gebruikersnaam, password, type
                FROM persoon
                INNER JOIN account
                ON persoon.account_id = account.ID
                JOIN usertype
                ON account.usertype_id = usertype.ID
                WHERE gebruikersnaam = :username ";
            
                /* will return the same PDOStatement, without any data attached to it. 
                Prepares a statement for execution and returns a statement object*/ 
                $myQuery = $this->pdo->prepare($sql);
                
                /* Executes the prepared statement, where i give the placholder the value of the variable $username */
                $myQuery->execute(
                    array(
                        'username' => $username
                    )
                );
                 
                /*Fetching rows */
                $rows = $myQuery->fetchAll(PDO::FETCH_OBJ);
                
                foreach ($rows as $row) {
                    $rowPWD = $row->password;
                }

                /* whether ip is from share internet */
                if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                }
                /* whether ip is from proxy */
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                /* whether ip is from remote address */
                else{
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                }

                if (count($rows) > 0) { 

                    $verify = password_verify($pwd, $rowPWD);

                        if ($verify) {
                            session_start();
                            
                            /*Logging the info to logs/ when user is logged in */
                            error_log('✓ - Login Success: username: '.$username.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/login/log_'.date("d-m-Y").'.log');
                            
                            /* If usertype is Admin, person will be redirect to Dir. Admin*/
                            if ($rows[0]->type === 'Admin') {
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;
    
                                header("Location: admin/"); 
                            }
                            /* If usertype is Docent, person will be redirect to Dir. Docent*/
                            elseif($rows[0]->type === 'Docent'){                        
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: docent/"); 
                            }
                            /* If usertype is Student, person will be redirect to Dir. Student*/
                            elseif($rows[0]->type === 'Student'){
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: student/"); 
                            }
                             /* If usertype is User, person will be redirect to Dir. User*/
                            else{
                                $_SESSION['username'] = $username;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: user/");
                            }
                        }else {
                                /*If username is right but pasword is wrong, error message will be shown,
                                and message will be logged to logs/ */
                                $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid Username or Password' .'</div>';
                                $_SESSION['message'] = $message;

                                error_log('X - Login Failed: username: '.$username.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/login/log_'.date("d-m-Y").'.log');                        }        
                
                }else {
                        /*If username & password are wrong, error message will be shown,
                        and message will be logged to logs/ */
                        $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid Username or Password' .'</div>';
                        $_SESSION['message'] = $message;

                        error_log('X - Login Failed: username: '.$username.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/login/log_'.date("d-m-Y").'.log');
                } 
                              
        } 
        catch (PDOException $e) { 
            throw $e;
        }    

    }
    
    /*Function for Admin to show overview of all users */
    public function getAllUsers(){
        try {
                /* Begin a transaction, turning off autocommit*/
                $this->pdo->beginTransaction();
                
                $sql = "SELECT account.ID,voornaam, tussenvoegsel, achternaam, email, gebruikersnaam, type
                FROM persoon
                INNER JOIN account
                ON persoon.account_id = account.ID
                JOIN usertype
                ON account.usertype_id = usertype.ID;
                ";
                
                /* will return the same PDOStatement, without any data attached to it.
                Prepares a statement for execution and returns a statement object */ 
                $myQuery = $this->pdo->prepare($sql);
                
                /* Executes the prepared statement */
                $myQuery->execute();
                
                /*Fetching rows */
                $row = $myQuery->fetchAll();

                if (count($row) > 0) {
                    $_SESSION['admin_row'] = $row;
                }

                /* Commit the changes */
                $this->pdo->commit(); 
          
        }
        catch (PDOException $e) {            
            throw $e;
        }
        
    }

    public function show($id){
        $sql = "SELECT account.ID,account.usertype_id AS typeID, voornaam, tussenvoegsel, achternaam, email, gebruikersnaam, type
        FROM persoon
        INNER JOIN account
        ON persoon.account_id = account.ID
        JOIN usertype
        ON account.usertype_id = usertype.ID
        WHERE account.id = :id";

      
        $myQuery = $this->pdo->prepare($sql);

        $myQuery->execute([
            'id' => $id
        ]);

        $user = $myQuery->fetch(PDO::FETCH_ASSOC);

        $this->voornaam =  $user['voornaam'];
        $this->tussenvoegsel =  $user['tussenvoegsel'];
        $this->achternaam =  $user['achternaam'];
        $this->email =  $user['email'];
        $this->gebruikersnaam =  $user['gebruikersnaam'];
        $this->type =  $user['type'];
        $this->typeID =  $user['typeID'];

    }
    public function edit($voornaam, $tussenvoegsel, $achternaam, $email, $username, $typeID){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "UPDATE account INNER JOIN persoon ON persoon.account_id = account.ID set email = :email, gebruikersnaam = :gebruikersnaam, usertype_id = :typeID, voornaam = :voornaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam  WHERE account.id = :id;";
            
            /*will return the same PDOStatement, without any data attached to it. 
            Prepares a statement for execution and returns a statement object */ 
            $myQuery = $this->pdo->prepare($sql);
            
            /* Executes the prepared statement */
            $myQuery->execute([
                'email' => $email,
                'gebruikersnaam' => $username,
                'typeID' => $typeID,
                'voornaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'id' => $_GET['id']
            ]);
     
            /* Commit the changes */
            $this->pdo->commit();

            header('Location: overzicht.php');

            exit;

        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function destroy(){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM persoon USING persoon INNER JOIN account on  persoon.account_id = account.ID WHERE account.id = :id;";
        
            /*will return the same PDOStatement, without any data attached to it. 
            Prepares a statement for execution and returns a statement object */ 
            $myQuery = $this->pdo->prepare($sql);
    
            /* Executes the prepared statement */
            $myQuery->execute([
                'id' => $_GET['id']
            ]);

            /* Commit the changes */
            $this->pdo->commit(); 

            header('Location: overzicht.php');

            exit;

        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
}
?>