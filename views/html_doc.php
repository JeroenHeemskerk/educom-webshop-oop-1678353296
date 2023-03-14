<?php

class HtmlDoc
{

  private function showBeginDocument()
  {
    echo '<!doctype html> 
              <html>';
  }

  private function showHeadStart()
  {
    echo '<head>';
  }

  protected function showHeadContent($page)
  {
    echo '
    <title>' . $page . '</title>';
  }

  private function showHeadEnd()
  {
    echo '</head>';
  }

  protected function showBodyStart()
  {

    echo '<body>' . PHP_EOL;
  }

  protected function showBodyContent()
  {
    echo '<h1>Body Content in HtmlDoc class</h1>';
  }

  protected function showBodyEnd()
  {
    echo '</body>' . PHP_EOL;
  }

  private function showEndDocument()
  {
    echo '</html>';
  }

  public function show($page)
  {
    $this->showBeginDocument();
    $this->showHeadStart();
    $this->showHeadContent($page);
    $this->showHeadEnd();
    $this->showBodyStart();
    $this->showBodyContent();
    $this->showBodyEnd();
    $this->showEndDocument();
  }
}
