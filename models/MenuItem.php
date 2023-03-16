<?php
class MenuItem
{
    private $page;
    private $label;

    public function __construct($page, $label)
    {
        $this->page = $page;
        $this->label = $label;
    }

    public function showMenuItem()
    {
        return PHP_EOL . '<li><a Href="index.php?page=' . $this->page . '">' . $this->label . '</a></li>';
    }
}
