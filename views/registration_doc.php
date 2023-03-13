<?PHP

include_once "forms_doc.php";


class RegistrationDoc extends FormsDoc
{
    protected function showContent($data)
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out your information to register');
        $this->showFormField('name', 'Name', 'name', $data);
        $this->showFormField('email', 'Email', 'email', $data);
        $this->showFormField('password', 'Password', 'password', $data);
        $this->showFormField('confirmPassword', 'Confirm Password', 'confirmPassword', $data);
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'register');
    }
}
