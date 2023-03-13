<?PHP

include_once "forms_doc.php";


class LoginDoc extends FormsDoc
{
    protected function showContent($data)
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Login');
        $this->showFormField('email', 'Email', 'email', $data);
        $this->showFormField('password', 'Password', 'password', $data);
        $this->showFormFieldSetEnd();
        $this->showFormEnd("Submit", "login");
    }
}
