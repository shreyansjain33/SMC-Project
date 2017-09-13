<?php
namespace my_app;
 
class Complaint
{
  private $name;
  private $address;
  private $description;
  private $phone;
  private $title;
 
  /*public function __construct( $message, $author_email ) {
      $this->message = $message;
      $this->author_email = $author_email;
  }*/
 
  public function getName() {
    return $this->name;
  }
 
  public function setMessage( $name ) {
      $this->name = $name;
  }
 
 
  public function getAddress() {
    return $this->address;
  } 
 
  public function setAddress( $address ) {
    $this->address = $address;
  }

    public function getDescription() {
    return $this->description;
  } 
 
  public function setDescription( $description ) {
    $this->description = $description;
  }
    public function getPhone() {
    return $this->phone;
  } 
 
  public function setPhone( $phone ) {
    $this->phone = $phone;
  }
    public function getTitle() {
    return $this->title;
  } 
 
  public function setTitle( $title ) {
    $this->title = $title;
  }
}

?>