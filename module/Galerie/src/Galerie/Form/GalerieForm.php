<?php

namespace Galerie\Form;

use Custom\Form\AbstractForm;


class GalerieForm extends AbstractForm
{

    public function initialize()
    {
        $elements = include __DIR__ . '/galerie.form.config.php';
        $this->addElements($elements);
        /* Méthode alternative
        $this->setMethod('post');
        $this->addElement('id', 'hidden');
        $this->addElement(
            'name',
            'text',
            $this->translate('Galerie_form_label_name')
        );
        $this->addElement(
            'description',
            'text',
            $this->translate('Galerie_form_label_description')
        );
        $this->addElement(
            'submit',
            'submit',
            null,
            array(
                'value' => 'Valider',
                'id' => 'submit_galerie_form',
            )
        );*/
    }

}
