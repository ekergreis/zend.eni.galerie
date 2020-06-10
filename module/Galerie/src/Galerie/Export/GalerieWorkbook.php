<?php

namespace Galerie\Export;

use Custom\Export\AbstractWorkbook;


class GalerieWorkbook extends AbstractWorkbook
{

    /**
     * Nom du fichier utilisé pour l'export.
     *
     * @return string
     */
    protected function nomFichier()
    {
        return 'export_galerie.xls';
    }




    /**
     * Méthode d'écriture des données dans la feuille courante.
     *
     * @return null
     */
    protected function writeData()
    {
        $this->ecrireCaseCourante("Nom", 'titre_string');
        $this->ecrireCaseCourante("Description", 'titre_string');
        $this->ecrireCaseCourante("Propriétaire", 'titre_string');
        $this->ecrireCaseCourante("Photos", 'titre_string');
        $this->nextLine();
        foreach($this->datas as $d) {
            $this->ecrireCaseCourante($d->name, 'case_string');
            $this->ecrireCaseCourante($d->description, 'case_string');
            $this->ecrireCaseCourante($d->username, 'case_string');
            $this->ecrireCaseCourante($d->nb, 'case_chiffre');
            $this->nextLine();
        }
    }




    /**
     * Mise en forme après écriture.
     *
     * @return null
     */
    protected function postFormats()
    {
        $this->current_worksheet->setColumn(0, 0, '10');
        $this->current_worksheet->setColumn(1, 1, '40');
        $this->current_worksheet->setColumn(2, 2, '10');
        $this->current_worksheet->setColumn(3, 3, '5');

        $this->current_worksheet->setRow(0, 50);
        $c = count($this->datas);
        for($i=1;$i<=$c;$i++) {
            $this->current_worksheet->setRow($i, 30);
        }

        $this->current_worksheet->setLandscape();
        $this->current_worksheet->hideGridLines();
    }  

}

