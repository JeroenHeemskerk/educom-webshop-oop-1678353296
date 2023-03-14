<?PHP

include_once "forms_doc.php";


class AddNewProductDoc extends FormsDoc
{
    //Override
    protected function showContent($data)
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out this form to add a new product');
        $this->showFormField('name', 'Name', 'text', $data);
        $this->showFormField('description', 'Description', 'text', $data);
        $this->showFormField('price', 'Price', 'text', $data);
        $this->showFormField('filename_img', 'Image', 'file', $data);
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Add to webshop', 'addnewproduct');
    }
}
