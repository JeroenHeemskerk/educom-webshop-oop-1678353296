<?PHP

include_once "forms_doc.php";

define("SALUTATIONS", array("mrs" => "Mrs.", "ms" => "Ms.", "mx" => "Mx.", "mr" => "Mr."));
define("COM_PREFS", array("phone" => "phone", "email" => "email"));


class ContactDoc extends FormsDoc
{
    protected function showContent()
    {

        $this->showFormStart();
        $this->showFormFieldSetStart('Personal');
        $this->showFormField('name', 'Name', 'name');
        $this->showFormField('email', 'Email', 'email');
        $this->showFormField('phone', 'Phone', 'phone');
        $this->showFormField(
            'salutation',
            'How can we address you?',
            'select',
            false,
            SALUTATIONS
        );
        $this->showFormFieldSetEnd();
        $this->showFormFieldSetStart('Preferred contact option *');
        $this->showFormField('contactOption', 'How can we reach you?', 'radio', true, COM_PREFS);
        $this->showFormFieldSetEnd();

        $this->showFormFieldSetStart('How can I help you?');
        $this->showFormField('message', 'Message', 'textarea');
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'contact');
    }
};
