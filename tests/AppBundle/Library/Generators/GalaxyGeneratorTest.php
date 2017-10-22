<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 22.10.17
 * Time: 17:49
 */

namespace Tests\AppBundle\Library\Generators;

use AppBundle\Entity\neo4j\Galaxy;
use AppBundle\Library\Generators\GalaxyGenerator;
use PHPUnit\Framework\TestCase;

class GalaxyGeneratorTest extends TestCase
{

    public function testPreparePlanets()
    {
        $galaxy = new Galaxy();
        $galaxy->setName("Andromeda");
        $galaxyGenerator = new GalaxyGenerator();
        $solarSystems = $galaxyGenerator->prepareSolarSystems($galaxy);
        $galaxy->setSolarSystems($solarSystems);
    }
}
