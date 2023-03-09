<?PHP

function showFormStart()
{
    echo '<div class="form-style-3">
  <form method="post" action="index.php" enctype="multipart/form-data">';
}

function showFormFieldSetStart($legend)
{
    echo '<fieldset>
    <legend>' . $legend . ':</legend> ';
}

function showFormField($field, $label, $type, $data, $required = true, $options = null)
{
    echo '<label for="' . $field . '"><span class="' .
        ($required ? "required" : "optional") . '">' . $label . '*</span>';

    switch ($type) {

        case "select":
            echo '<select name="' . $field . '" class="select-field">';
            foreach ($options as $key => $value) {
                echo '<option ' . ($key == $data[$field] ? ' selected ' : '') .
                    'value="' . $key . '">' . $value . '</option>';
            }
            echo '</select>';
            break;

        case "radio":

            foreach ($options as $key => $value) {
                $optionId = $field . '_' . $key;
                echo '<label for="' . $key . '">' . $value . '</label><input ' .
                    ($key == $data[$field] ? ' checked ' : '') . 'type="' . $type . '"
                   name="' . $field . '" id="' . $optionId . '" value="' . $key . '">';
            }
            break;

        default:
            echo '<input type="' . $type . '" class="input-field" name="' . $field . '" value="' . $data[$field] . '" />';
            break;
    }
    echo '</label>';
    if (array_key_exists($field . "Err", $data)) {
        echo '  <span class="error">' . $data[$field . "Err"] . '</span>';
        echo '  <span class="error">' . $data['genericErr'] . '</span>';
    }
}

function showFormFieldSetEnd()
{
    echo '</fieldset>';
}

function showFormEnd($submitButtonText, $page)
{
    echo '<fieldset>              
              <label><input type="submit" value="' . $submitButtonText . '" /></label>
              <input type="hidden" name="page" value="' . $page . '">                                                
              </fieldset>
          </form>
        </div>';
}
