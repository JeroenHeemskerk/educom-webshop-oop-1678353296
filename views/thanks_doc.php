<?PHP

include_once "basic_doc.php";


class ThanksDoc extends BasicDoc
{
    protected function showContent()
    {
        echo '
        <p>Thank you for your reply!</p>

        <div>Name: ' . $this->model->salutation . " " . $this->model->name . '</div>
        <div>Email: ' . $this->model->email . ' </div>
        <div>Phone: ' . $this->model->phone . '</div>
        <div>Preferred Contact Option: ' . $this->model->contactOption . '</div>
        <div>Message: ' . $this->model->message . '</div>        
        </div> ';
    }
}
