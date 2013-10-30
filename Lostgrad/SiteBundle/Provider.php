<?php
class Provider
{
    protected $provider_id = 0;        //id
    protected $provider_name = 0;      //provider's name, e.g. indeed/coursera
    protected $category_type = 0;      //e.g. 2= courses, 3= jobs
   
    
    /**
     * Access modifier to set protected properties
     */
    public function __set($var, $val)
    {
            $this->$var = $val;  
    }


    /**
     * Access modifier to get protected properties
     */
    public function &__get($var)
    {
            return $this->$var;
    }

               
   public function addProvider($h)
  {
    $sql = "INSERT INTO lostgrad_providers SET provider_name= %s, category_id= %d";
		
    $h->db->query($h->db->prepare
            ($sql, 
            $this->provider_name, 
            $this->category_id
            ));
  }
    
}
?>
