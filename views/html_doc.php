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

  protected function showHeadContent()
  {
    echo '
    <title>not found, error 404</title>';
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
    echo '<h1>This page does not seem to exist.</h1>';
  }

  protected function showBodyEnd()
  {
    echo '</body>' . PHP_EOL;
  }

  private function showEndDocument()
  {
    echo '</html>';
  }

  public function show()
  {
    $this->showBeginDocument();
    $this->showHeadStart();
    $this->showHeadContent();
    $this->showHeadEnd();
    $this->showBodyStart();
    $this->showBodyContent();
    $this->showBodyEnd();
    $this->showEndDocument();
  }
}
