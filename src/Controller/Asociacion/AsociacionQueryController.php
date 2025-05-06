<?php


/**
 * src/Controller/Asociacion/AsociacionesRelationsController.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

 namespace TDW\ACiencia\Controller\Asociacion;

 use TDW\ACiencia\Controller\Element\ElementBaseQueryController;
 
 class AsociacionQueryController extends ElementBaseQueryController
 {
     public const PATH_ASOCIACIONES = '/asociaciones';
 
     public static function getEntityClassName(): string
     {
         return \TDW\ACiencia\Entity\Asociacion::class;
     }
 
     public static function getEntityIdName(): string
     {
         return 'asociacionId';
     }
 }
