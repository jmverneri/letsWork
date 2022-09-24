<?php

namespace DAO;

    use \PDO as PDO;
    use DAO\QueryType as QueryType;
     use Exception as Exception;

class Connection
{
    private $pdo = null; ///Objetos de Datos PHP
    private $pdoStatement = null;
    private static $instance = null;


    public function __construct()
    {
        try {
            $this->pdo = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

 /*   public function execute($query, $parameters = array())
    {
         try
         {
         // I create a statement by calling prepare. This returns a statement object
              $this->pdoStatement = $this->pdo->prepare($query);
               
              foreach($parameters as $parameterName => $value)
              {
                   // I replace the parameter markers with the actual values using the bindParam () method.
                   $this->pdoStatement->bindParam(":".$parameterName, $value);
                  
              }
          

              $this->pdoStatement->execute();
             // echo $this->pdoStatement;
              //die;
              return $this->pdoStatement->fetchAll();
         }
         catch(\Exception $ex)
         {
              throw $ex; 
         }
    }   


    public function executeNonQuery($query, $parameters = array())
    {
         
         try
         {
              // Creo una sentencia llamando a prepare. Esto devuelve un objeto statement
              $this->pdoStatement = $this->pdo->prepare($query);
              foreach($parameters as $parameterName => $value)
              {
                   // Reemplazo los marcadores de parametro por los valores reales utilizando el método bindParam().
               //    $this->pdoStatement->bindParam(":".$parameterName, $value);
               $this->pdoStatement->bindParam(":$parameterName", $parameters[$parameterName]);
              }
      
              $this->pdoStatement->execute();
              return $this->pdoStatement->rowCount();
         }
         catch(\Exception $ex)
         {   
              throw $ex;
         }
    }*/

    public function Execute($query, $parameters = array(), $queryType = QueryType::Query)
    {
       try
       {
           $this->Prepare($query);
           
           $this->BindParameters($parameters, $queryType);
           
           $this->pdoStatement->execute();

           return $this->pdoStatement->fetchAll();
       }
       catch(Exception $ex)
       {
           throw $ex;
       }
   }
   
   public function ExecuteNonQuery($query, $parameters = array(), $queryType = QueryType::Query)
    {            
       try
       {
           $this->Prepare($query);
           
           $this->BindParameters($parameters, $queryType);

           $this->pdoStatement->execute();

           return $this->pdoStatement->rowCount();
       }
       catch(Exception $ex)
       {
           throw $ex;
       }        	    	
   }
   
   private function Prepare($query)
   {
       try
       {
           $this->pdoStatement = $this->pdo->prepare($query);
       }
       catch(Exception $ex)
       {
           throw $ex;
       }
   }
   
   private function BindParameters($parameters = array(), $queryType = QueryType::Query)
   {
       $i = 0;

       foreach($parameters as $parameterName => $value)
       {                
           $i++;

           if($queryType == QueryType::Query)
               $this->pdoStatement->bindParam(":".$parameterName, $parameters[$parameterName]);
           else
               $this->pdoStatement->bindParam($i, $parameters[$parameterName]);
       }
   }
}
    



?>
