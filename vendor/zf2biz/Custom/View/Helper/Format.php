<?php 

namespace Custom\View\Helper; 
 
use Zend\View\Helper\AbstractHelper; 
 
class Format extends AbstractHelper 
{ 

    protected $text = null;

    public function __invoke($text = null, $format = null)
    {
        $this->text = $text;
        if (null === $text || null === $format) {
            return $this;
        }
        switch ($format) {
            case 'strong': return $this->strong();
            case 'em': return $this->em();
            case 'info': return $this->info();
            case 'warning': return $this->warning();
            case 'error': return $this->error();
            default: return $text;
        }
    }

    public function strong($text = null)
    {
        if (null === $text) {
            $text = $this->text;
        }
        return "<strong>{$text}</strong>";
    }

    public function em($text = null)
    {
        if (null === $text) {
            $text = $this->text;
        }
        return "<strong>{$text}</strong>";
    }

    public function info($text = null)
    {
        if (null === $text) {
            $text = $this->text;
        }
        return '<div class="alert-info">' . $text . '</div>';
    }


    public function warning($text = null)
    {
        if (null === $text) {
            $text = $this->text;
        }
        return '<div class="alert-warning">' . $text . '</div>';
    }


    public function error($text = null)
    {
        if (null === $text) {
            $text = $this->text;
        }
        return '<div class="alert-error">' . $text . '</div>';
    }

}
