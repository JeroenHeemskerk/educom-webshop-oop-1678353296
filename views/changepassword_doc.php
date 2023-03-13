<?PHP

include_once "forms_doc.php";


class ChangePasswordDoc extends FormsDoc
{
    protected function showContent($data)
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out your information to change your password');
        $this->showFormField('password', 'Password', 'password', $data);
        $this->showFormField('newPassword', 'Choose a new password', 'password', $data);
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'changepassword');
    }
}