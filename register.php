<?php

include_once 'forms.php';


function showContent($data)
{
  showFormStart();
  showFormFieldSetStart('Fill out your information to register');
  showFormField('name', 'Name', 'name', $data);
  showFormField('email', 'Email', 'email', $data);
  showFormField('password', 'Password', 'password', $data);
  showFormField('confirmPassword', 'Confirm Password', 'confirmPassword', $data);
  showFormFieldSetEnd();
  showFormEnd('Submit', 'register');
}
