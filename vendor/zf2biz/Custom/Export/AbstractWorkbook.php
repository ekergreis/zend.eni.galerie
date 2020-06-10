<?php

/**
 * ZF2BIZ
 *
 * PHP version 5.3
 *
 * @category  Components
 * @package   Custom\Export
 * @author    Sébastien Chazallet <sebastien.chazallet@laposte.net>
 * @copyright 2011 InsPyration
 * @license   GNU GPL http://www.gnu.org/licenses/gpl.html
 * @link      http://zf2.biz
 * @since     0.0.1
 *
 */

namespace Custom\Export;

/**
 * @see Spreadsheet_Excel_Writer
 */

require_once 'Spreadsheet/Excel/Writer.php';

/**
 * Cette classe permet de renvoyer un fichier Excel.
 *
 * Elle rajoute des facilités telles que :
 * > la gestion de la ligne courante
 * > la gestion de la case courante
 * > le passage automatisé à la case suivante  (celle de droite)
 * > le passage automatisé à la ligne suivante (celle du dessous)
 * > la gestion des formats
 *
 * 
 * Elle permet d'aider à générer facilement des exports Excel,
 * mais ne contient PAS de logique de présentation,
 * conformément aux principes de séparation du code
 *
 * @category  Components
 * @package   Custom\Export
 * @author    Sébastien Chazallet <sebastien.chazallet@laposte.net>
 * @copyright 2011 InsPyration
 * @license   GNU GPL http://www.gnu.org/licenses/gpl.html
 * @link      http://zf2.biz
 * @since     0.0.1
 *
 */

abstract class AbstractWorkbook
{

    /**
     * Document D'export
     * @var Spreadsheet_Excel_Writer
     */
    protected $workbook;

    /**
     * Feuille courante
     * @var Spreadsheet_Excel_Worksheet
     */
    protected $current_worksheet;

    /**
     * Ligne courante
     * @var int
     */
    protected $current_line = 0;
    /**
     * Colonne courante
     * @var int
     */
    protected $current_column = 0;

    /**
     * Données à exporter
     * @var array
     */
    protected $datas;


    /**
     * Formats disponibles.
     * @var array
     */
    protected $formats = array();


    /**
     * Liste des styles utilisés pour les chiffres
     * constante de type tableau
     * @var array
     */
    protected $suffixes_entier = array(
        'chiffre',
    );


    /**
     * Créateur de l'export
     *
     * @param array $datas données à écrire
     *
     * @return null
     */
    public function build ($datas)
    {
        $this->datas = $datas;
        //Initialisation de la feuille Excel.
        $this->initWorkbook();
        // Initialisation de la feuille courante
        $this->initCurrentWorksheet();
        // Initialisation des formats
        $this->initFormats();

        //On ecrit les données
        $this->writeData();

        // Finalisation du formatage
        $this->postFormats();

        // Fermeture de la feuille Excel
        $this->closeWorkbook();

    }

    /**
     * Initialisation de l'export Excel.
     * Mise en place du nom du fichier et de l'UTF-8.
     *
     * @return null
     */
    protected function initWorkbook()
    {
        $this->workbook = new \Spreadsheet_Excel_Writer();
        $this->workbook->setVersion(8);
        $this->workbook->send($this->nomFichier());
    }

    /**
     * Nom du fichier utilisé pour l'export.
     *
     * @return string
     */
    abstract protected function nomFichier();

    /**
     * Initialisation d'une feuille qui devient la feuille courante.
     *
     * @return null
     */
    protected function initCurrentWorksheet()
    {
        $this->current_worksheet = $this->workbook->addWorksheet();
        $this->current_worksheet->setInputEncoding('utf-8');
    }

    /**
     * Permet de composer les formats à utiliser.
     *
     * @return null
     */
    protected function initFormats()
    {
        $this->initFormatTitreString();
        $this->initFormatCaseString();
        $this->initFormatCaseChiffre();
    }


    /**
     * Initialisation d'un format pour un classeur
     *
     * @return null
     */
    protected function initFormatTitreString()
    {
        $format = &$this->workbook->addFormat();
        $format->setSize(10);
        $format->setBold();
        $format->setAlign('center');
        $format->setAlign('vcenter');
        $format->setBottom(1);
        $format->setTop(1);
        $format->setLeft(1);
        $format->setRight(1);
        $format->setTextWrap();
        $format->setFgColor(30);
        $this->formats['titre_string'] = $format;
    }

    /**
     * Initialisation d'un format pour un classeur
     *
     * @return null
     */
    protected function initFormatCaseString()
    {
        $format = &$this->workbook->addFormat();
        $format->setSize(10);
        $format->setAlign('left');
        $format->setAlign('vcenter');
        $format->setTop(1);
        $format->setBottom(1);
        $format->setRight(1);
        $format->setLeft(1);
        $this->formats['case_string'] = $format;
    }

    /**
     * Initialisation d'un format pour un classeur
     *
     * @return null
     */
    protected function initFormatCaseChiffre()
    {
        $format = &$this->workbook->addFormat();
        $format->setSize(10);
        $format->setAlign('center');
        $format->setAlign('vcenter');
        $format->setTop(1);
        $format->setBottom(1);
        $format->setRight(1);
        $format->setLeft(1);
        $format->setNumFormat('0.00');
        $this->formats['case_chiffre'] = $format;
    }

    /**
     * Méthode d'écriture des données dans la feuille courante.
     *
     * @return null
     */
    abstract protected function writeData();

    /**
     * Mise en forme après écriture.
     *
     * @return null
     */
    abstract protected function postFormats();

    /**
     * Fermeture propre de l'export Excel.
     * Clot son écriture et renvoie l'objet au client.
     *
     * @return null
     */
    protected function closeWorkbook()
    {
        $this->workbook->close();
    }




    /**
     * Méthode permettant d'écrire quelque chose dans une case.
     *
     * @param string $line   numero de la ligne, commence par 0.
     * @param string $column numero de la colonne, commence par 0.
     * @param string $value  valeur à inscrire dans la casae
     * @param string $format format à utiliser pour la case
     *
     * @return null
     */
    protected function ecrireCase($line, $column, $value, $format)
    {
        $details = explode('_', $format);
        if (in_array($details[1], $this->suffixes_entier)) {
            $int = true;
        } else {
            $int = false;
        }
        if (!$value) {
            $this->current_worksheet->writeBlank(
                $line,
                $column,
                $this->formats[$format]
            );
        } else {
            if ($int === false) {
                $this->current_worksheet->writeString(
                    $line,
                    $column,
                    $value,
                    $this->formats[$format]
                );
            } else {
                $this->current_worksheet->writeNumber(
                    $line,
                    $column,
                    $value,
                    $this->formats[$format]
                );
            }
        }
    }

    /**
     * Méthode permettant d'écrire quelque chose dans la case courante
     *
     * @param string $value   valeur à mettre dans la case courante
     * @param string $format  format à utiliser pour la case courante
     *
     * @return null
     */
    protected function ecrireCaseCourante($value, $format)
    {
        $line = $this->current_line;
        $column = $this->current_column;
        $this->ecrireCase(
            $this->current_line,
            $this->current_column,
            $value,
            $format
        );
        $this->next();
    }

    /**
     * Méthode permettant de merger avec la case précédente.
     *
     * @param string $line   numero de la ligne, commence par 0.
     * @param string $column numero de la colonne, commence par 0.
     *
     * @return null
     */
    protected function mergerAvecCasePrecedente($line=null, $column=null)
    {
        if ($line === null ) {
            $line = $this->current_line;
        }
        if ($column === null) {
            $column = $this->current_column;
        }
        $this->current_worksheet->mergeCells(
            $line,
            $column-1,
            $line,
            $column
        );
    }

    /**
     * Passage à la case suivante.
     *
     * @return null
     */
    protected function next()
    {
        $this->current_column++;
    }

    /**
     * Passage à la ligne suivante.
     *
     * @return null
     */
    protected function nextLine()
    {
        $this->current_column=0;
        $this->current_line++;
    }

}
