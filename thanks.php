<?PHP

function showContent($data)
{
    echo '
        <p>Thank you for your reply!</p>

        <div>Name: ' . SALUTATIONS[$data["salutation"]] . " " . $data["name"] . '</div>
        <div>Email: ' . $data["email"] . ' </div>
        <div>Phone: ' . $data["phone"] . '</div>
        <div>Preferred Contact Option: ' . COM_PREFS[$data["contactOption"]] . '</div>
        <div>Message: ' . $data["message"] . '</div>        
    </div> ';
}
