<?PHP

include_once "forms_doc.php";


class RegisterDoc extends FormsDoc
{
    protected function showContent()
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out your information to register');
        $this->showFormField('name', 'Name', 'name');
        $this->showFormField('email', 'Email', 'email');
        $this->showFormField('password', 'Password', 'password');
        $this->showFormField('confirmPassword', 'Confirm Password', 'confirmPassword');
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'register');
    }
}
