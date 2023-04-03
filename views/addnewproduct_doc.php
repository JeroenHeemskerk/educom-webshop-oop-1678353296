<?PHP

include_once "forms_doc.php";


class AddNewProductDoc extends FormsDoc
{
    //Override 
    protected function showContent()
    {
        $this->showFormStart();
        $this->showFormFieldSetStart('Fill out this form to add a new product');
        $this->showFormField('name', 'Name', 'text');
        $this->showFormField('description', 'Description', 'text');
        $this->showFormField('price', 'Price', 'text',);
        $this->showFormField('filename_img', 'Image', 'file');
        $this->showFormField('productId', '', 'hidden');
        $this->showFormField('oldfilenameimg', '', 'hidden');
        $this->showFormFieldSetEnd();
        $this->showFormEnd('Add to webshop', 'addnewproduct');
    }
}
