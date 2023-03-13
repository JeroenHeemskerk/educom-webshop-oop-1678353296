<?PHP

include_once "forms_doc.php";


class ContactDoc extends FormsDoc
{
    protected function showContent($data)
    {

        $this->showFormStart();
        $this->showFormFieldSetStart('Personal');
        $this->showFormField('name', 'Name', 'name', $data);
        $this->showFormField('email', 'Email', 'email', $data);
        $this->showFormField('phone', 'Phone', 'phone', $data);
        $this->showFormField(
            'salutation',
            'How can we address you?',
            'select',
            $data,
            false,
            SALUTATIONS
        );
        $this->showFormFieldSetEnd();
        $this->showFormFieldSetStart('Preferred contact option *');
        $this->showFormField('contactOption', 'How can we reach you?', 'radio', $data, true, COM_PREFS);
        $this->showFormFieldSetEnd();

        $this->showFormFieldSetStart('How can I help you?');
        $this->showFormField('message', 'Message', 'textarea', $data);
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Submit', 'contact');
    }
};
