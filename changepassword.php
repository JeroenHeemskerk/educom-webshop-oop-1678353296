<?php

include_once 'forms.php';

function showContent($data)
{
  showFormStart();
  showFormFieldSetStart('Fill out your information to change your password');
  showFormField('password', 'Password', 'password', $data);
  showFormField('newPassword', 'Choose a new password', 'password', $data);
  showFormFieldSetEnd();
  showFormEnd('Submit', 'changepassword');
}
