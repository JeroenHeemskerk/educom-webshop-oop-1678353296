<?PHP

include_once "basic_doc.php";


class ThanksDoc extends BasicDoc
{
    protected function showContent($data)
    {
        echo '
        <p>Thank you for your reply!</p>

        <div>Name: ' . $data["salutation"] . " " . $data["name"] . '</div>
        <div>Email: ' . $data["email"] . ' </div>
        <div>Phone: ' . $data["phone"] . '</div>
        <div>Preferred Contact Option: ' . $data["contactOption"] . '</div>
        <div>Message: ' . $data["message"] . '</div>        
        </div> ';
    }
}
