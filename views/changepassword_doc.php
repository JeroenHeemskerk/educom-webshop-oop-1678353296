<?PHP

include_once "forms_doc.php";


class ChangePasswordDoc extends FormsDoc
{
    protected function showContent()
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out your information to change your password');
        $this->showFormField('password', 'Password', 'password');
        $this->showFormField('newPassword', 'Choose a new password', 'password');
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'changepassword');
    }
}
