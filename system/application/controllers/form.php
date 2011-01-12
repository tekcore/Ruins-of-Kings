<?php
class Form extends Controller {
function index()
{
    $this->load->library('validation');
$rules['fname'] = "required";
$rules['email'] = "required|valid_email";
$this->validation->set_rules($rules);

#Input and textarea field attributes
$data["fname"] = array('name' => 'fname', 'id' => 'fname');
$data['email'] = array('name' => 'email', 'id' => 'email');
$data['comments'] = array('name' => 'comments', 'id' => 'comments', 'rows' => 3, 'cols' => 40);

#Checkbox attributes
$data['purpose'] = array('name' => 'seminar[]', 'id' => 'purpose', 'value' => 'Purpose of Prayer', 'checked' => FALSE);
$data['prepare'] = array('name' => 'seminar[]', 'id' => 'prepare', 'value' => 'Prepare for Prayer', 'checked' => FALSE);
$data['principles'] = array('name' => 'seminar[]', 'id' => 'principles', 'value' => 'Principles of Prayer', 'checked' => FALSE);
$data['power'] = array('name' => 'seminar[]', 'id' => 'power', 'value' => 'Power in Prayer', 'checked' => FALSE);

#Load our view    
if ($this->validation->run() == FALSE)
{
  $this->load->view('form_view', $data);
}
else
{
  $fname = $this->input->post('fname');
  $email = $this->input->post('email');
  $comments = $this->input->post('comments');
  $seminars = "";

  foreach($this->input->post('seminar') as $value){
    $seminars .= "$value\n";
  } 

  $message = "$fname ($email) would like to register for the following seminars:\n$seminars and had this to say:\n\n$comments";

  $this->email->from($email, $fname);
  $this->email->to('john.doe@welovejesus.com');
  $this->email->subject('Seminar Registration');
  $this->email->message($message);
  $this->email->send();
  $this->load->view('formsuccess');
}
}
/*
function submit()
{ 
  #Get POST data
  $fname = $this->input->post('fname');
  $email = $this->input->post('email');
  $comments = $this->input->post('comments');
  $seminars = "";
    
  foreach($this->input->post('seminar') as $value){
      $seminars .= "$value\n";
  }    

  $message = $fname . " would like to register for the following   seminars\n" . $seminars;

  #Set our e-mail fields
  $this->email->from($email, $fname);
  $this->email->to('seba@stekkz.com');
  $this->email->subject('Seminar Registration');
  $this->email->message($message);
  $this->email->send();
  #load our view file
if ($this->validation->run() == FALSE)
{
  $this->load->view('form_view', $data);
}
else
{
  $this->load->view('formsuccess');
}
}*/
}
?>