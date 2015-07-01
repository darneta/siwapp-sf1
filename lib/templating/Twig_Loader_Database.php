<?php

class Twig_Loader_Database implements Twig_LoaderInterface
{
  public function getSource($name)
  {
    if (substr($name, 0, 12) === "email-title-") {
      return $this->findTemplate(substr($name, 12))->getEmailTitle();
    }

    if (substr($name, 0, 15) === "email-filename-") {
      return $this->findTemplate(substr($name, 15))->getEmailFilename();
    }

    if (substr($name, 0, 6) === "email-") {
      return $this->findTemplate(substr($name, 6))->getEmailTemplate();
    }

    return $this->findTemplate($name)->getTemplate();
  }
  
  public function getCacheKey($name)
  {
    if ($name !== $this->removeTemplateSuffix($name)) {
      return $name;
    }

    return $this->findTemplate($name)->getName();
  }
  
  public function isFresh($name, $time)
  {
    return strtotime($this->findTemplate($name)->getUpdatedAt()) < $time;
  }

  protected function removeTemplateSuffix($name) {
    if (substr($name, 0, 12) === "email-title-") {
      return substr($name, 12);
    }

    if (substr($name, 0, 15) === "email-filename-") {
      return substr($name, 15);
    }

    if (substr($name, 0, 6) === "email-") {
      return substr($name, 6);
    }

    return $name;
  }

  protected function findTemplate($name)
  {
    $name = $this->removeTemplateSuffix($name);

    if (is_numeric($name))
    {
      $template = Doctrine::getTable('Template')->find($name);
    }
    else
    {
      $template = Doctrine::getTable('Template')->findOneBy('Slug', $name);
    }
    
    if (!$template)
    {
      throw new LogicException(sprintf('Template "%s" is not defined.', $name));
    }
    
    return $template;
  }
}
