<?PHP

include_once "forms_doc.php";


class LoginDoc extends FormsDoc
{
    protected function showContent()
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Login');
        $this->showFormField('email', 'Email', 'email');
        $this->showFormField('password', 'Password', 'password');
        $this->showFormFieldSetEnd();
        $this->showFormEnd("Submit", "login");
    }
}
