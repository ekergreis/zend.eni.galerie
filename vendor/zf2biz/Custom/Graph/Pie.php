<?php

/**
 * ZF2BIZ
 *
 * PHP version 5.3
 *
 * @category  Components
 * @package   Custom\Graph
 * @author    Sébastien Chazallet <sebastien.chazallet@laposte.net>
 * @copyright 2011 InsPyration
 * @license   GNU GPL http://www.gnu.org/licenses/gpl.html
 * @link      http://zf2.biz
 * @since     0.0.1
 *
 */

namespace Custom\Graph;

/**
 * @see jpgraph
 */

use JpGraph\JpGraph;
use Graph;
use PiePlot3D;
use PiePlot;

/**
 * Cette classe permet de créer aisément un diagramme.
 *
 * Elle rajoute des facilités telles que :
 * > la gestion des métadonnées du graphique est laissé à la classe fille
 * > la gestion des particularités offertes par la librairie dans des hooks
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
class Pie
{

    /**
     * Données affichées par le diagramme de gantt
     * @var array
     */
    protected $datas = array();

    /**
     * Titre du graphique, si la méthode getTitle n'est pas surchargée
     * @var string
     */
    protected $title = "Titre du graphique";

    /**
     * Légendes accompagnant chaque donnée
     * @var array
     */
    protected $legends = array();

    /**
     * Permet de déterminer la largeur du graphique
     * @var int
     */
    protected $x = 600;

    /**
     * Permet de déterminer la hauteur du graphique
     * @var int
     */
    protected $y = 400;

    /**
     * Permet de déterminer si le graphiques est à plat ou 3D
     * @var bool
     */
    protected $dim3D = false;


    /**
     * Constructeur
     *
     * @param array $datas données de base
     * @param array $infos données textuelles
     *
     * @return null
     */
    public function __construct ($datas, $legends)
    {
        $this->datas = $datas;
        $this->legends = $legends;

        $this->createDiagram();
    }

    /**
     * Méthode de création du diagramme
     *
     * @return null
     */
    protected function createDiagram()
    {
        // Create the basic graph
        JpGraph::load();

        JpGraph::module('pie');
        $graph  = new Graph($this->x, $this->y);
        if ($this->dim3D) {
            $graph->SetShadow();
        }
        $graph->title->Set($this->getTitle());

        /*
        // Create a pie
        if ($this->dim3D) {
            $oPie = new PiePlot3D($this->datas);
        } else {
            $oPie = new PiePlot($this->datas);
        }
        foreach($this->getSlices() as $s) {
            $oPie->ExplodeSlice($s);
        }
        if ($this->getColors()) {
            $oPie->SetSliceColors($this->getColors());
        }
        $oPie->SetLegends($this->legends);
        $oPie->SetCenter(0.5);
        $oPie->SetValueType(PIE_VALUE_ABS);
        $oPie->value->SetFormat($this->getFormat());

        // Add pie to graph
        $graph->add($oPie);
        */
        $graph->legend->SetPos(0.5, 0.98, 'center', 'bottom');

        // ... and stroke the graph
        //$this->content = $graph->Stroke(_IMG_HANDLER);
        $graph->Stroke();
    }


    /**
     * Méthode à surcharger pour définir des données à mettre en évidence
     *
     * @return array
     */
    protected function getSlices()
    {
        return array();
    }

    /**
     * Méthode à surcharger pour définir des couleurs personnalisées
     *
     * @return array
     */
    protected function getColors()
    {
        return array();
    }

    /**
     * Méthode à surcharger pour définir une format de données particulier
     * pour la légende.
     *
     * Par défaut, c'est '%d', mais cela peut être 'total de %d parts'
     *
     * @return string
     */
    protected function getFormat()
    {
        return '%d';
    }

    /**
     * Méthode à surcharger pour définir un titre.
     *
     * Utile lorsque le titre dépend de données variables.
     * Si le titre est statique, autant se contenter de modifier la propriété
     *
     * @return string
     */
    protected function getTitle()
    {
        return $this->title;
    }

    /**
     * Méthode alternative permettant de définir un titre
     *
     * Utile lorsque l'on ne souhaite pas surcharger la classe courante.
     *
     * @return string
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

}
