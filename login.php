<?php

include_once 'forms.php';

function showContent($data)
{
  showFormStart();
  showFormFieldSetStart('Login');
  showFormField('email', 'Email', 'email', $data);
  showFormField('password', 'Password', 'password', $data);
  showFormFieldSetEnd();
  showFormEnd("Submit", "login");
}
