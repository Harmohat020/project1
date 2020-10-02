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
                
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);  

                $sql2 = "INSERT INTO account(account_id, email, password, gebruikersnaam, usertype_id)
                VALUES(NULL, '$email', '$pwd', '$username', 4);";

                $myQuery = $this->pdo->prepare($sql2);
                
                /* Executing  */
                $myQuery->execute();
                
                /* Getting the last inserted ID value */
                $ID = $this->pdo->lastInsertId();
                
                $sql = "INSERT INTO persoon(persoon_id, voornaam, tussenvoegsel, achternaam, account_id)
                VALUES(NULL, '$voornaam', '$tussenvoegsel', '$achternaam', '$ID');";
                    
                $myQuery = $this->pdo->prepare($sql);
        
                $myQuery->execute();

                /* Commit the changes */
                $this->pdo->commit();
                                
                /* Prevents that data is always added to the table during refresh */
                header("Location: index.php");
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
                ON persoon.account_id = account.account_id
                JOIN usertype
                ON account.usertype_id = usertype.usertype_id
                WHERE gebruikersnaam = :username ";
            
                /*  Preparing  object */
                $myQuery = $this->pdo->prepare($sql);

                $myQuery->execute(
                    array(
                        'username' => $username
                    )
                );
                
                $rows = $myQuery->fetchAll(PDO::FETCH_OBJ);
                
                foreach ($rows as $row) {
                    $rowPWD = $row->password;
                }

                if (count($rows) > 0) { 

                    $verify = password_verify($pwd, $rowPWD);

                        if ($verify) {
                            session_start();

                            if ($rows[0]->type === 'Admin') {
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;
    
                                header("Location: admin/"); 
                            }elseif($rows[0]->type === 'Docent'){                        
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: docent/"); 
                            }elseif($rows[0]->type === 'Student'){
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $pwd;
                                $_SESSION['row'] = $rows;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: student/"); 
                            }else{
                                $_SESSION['username'] = $username;
                                $_SESSION['type'] = $rows[0]->type;

                                header("Location: user/");
                            }
                        }else {
                            $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid Username or Password' .'</div>';
                            $_SESSION['message'] = $message;
                        }        
                
                }else {
                     $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid Username or Password' .'</div>';
                     $_SESSION['message'] = $message;
                } 
                /* Commit the changes */
                $this->pdo->commit();                    

        } 
        catch (PDOException $e) { 
            throw $e;
        }    

    }
    public function getAllUsers(){
        try {
                /* Begin a transaction, turning off autocommit */
                $this->pdo->beginTransaction();
                
                $sql = "SELECT voornaam, tussenvoegsel, achternaam, email, gebruikersnaam, type
                FROM persoon
                INNER JOIN account
                ON persoon.account_id = account.account_id
                JOIN usertype
                ON account.usertype_id = usertype.usertype_id;
                ";

                $myQuery = $this->pdo->prepare($sql);

                $myQuery->execute();

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

    public function create_person_admin($voornaam, $tussenvoegsel, $achternaam, $email, $pwd, $gebruikersnaam, $type){
          try {
                  /* Begin a transaction, turning off autocommit */
                  $this->pdo->beginTransaction();

                  $pwd = password_hash($pwd, PASSWORD_DEFAULT);  
  
                  $sql2 = "INSERT INTO account(account_id, email, password, gebruikersnaam, usertype_id)
                  VALUES(NULL, '$email', '$pwd', '$gebruikersnaam', '$type');";
  
                  $myQuery = $this->pdo->prepare($sql2);
                  
                  /* Execute de query */
                  $myQuery->execute();
                  
                  /* Getting the last inserted ID value */
                  $ID = $this->pdo->lastInsertId();
                  
                  $sql = "INSERT INTO persoon(persoon_id, voornaam, tussenvoegsel, achternaam, account_id)
                  VALUES(NULL, '$voornaam', '$tussenvoegsel', '$achternaam', '$ID');";
                      
                  $myQuery = $this->pdo->prepare($sql);
          
                  $myQuery->execute();
  
                  /* Commit the changes */
                  $this->pdo->commit();
                                  
                  /* Prevents that data is always added to the table during refresh */
                  header("Location: create.php");
          } 
          catch (PDOException $e) {
              /* Recognize mistake and roll back changes */
              $this->pdo->rollback();
              
              throw $e;
          }
       
    }


}
?>