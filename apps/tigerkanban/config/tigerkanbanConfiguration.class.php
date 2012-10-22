<?php

class tigerkanbanConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
      sfWidgetFormSchema::setDefaultFormFormatterName('simple');
  }
}
