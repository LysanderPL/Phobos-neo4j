<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 22.10.17
 * Time: 16:43
 */

namespace AppBundle\Entity\neo4j;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Planet")
 */
class Planet
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    private $id;
    /**
     * @OGM\property(type="string")
     * @var string
     */
    private $name;
    /**
     * @var Planet[]|Collection
     * @OGM\Relationship(type="NEARBY_PLANET", direction="BOTH", collection=true, mappedBy="nearbyPlanets", targetEntity="Planet")
     */
    private $nearbyPlanets;
    /**
     * @var SolarSystem
     * @OGM\Relationship(type="PLANET_IN_SOLAR_SYSTEM", direction="INCOMING", collection=false, mappedBy="planets", targetEntity="Galaxy")
     */
    private $solarSystem;
    /**
     * @var Galaxy
     * @OGM\Relationship(type="PLANET_IN_GALAXY", direction="INCOMING", collection=false, mappedBy="planets", targetEntity="Galaxy")
     */
    private $galaxy;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return SolarSystem
     */
    public function getSolarSystem(): SolarSystem
    {
        return $this->solarSystem;
    }

    /**
     * @param SolarSystem $solarSystem
     */
    public function setSolarSystem(SolarSystem $solarSystem)
    {
        $this->solarSystem = $solarSystem;
    }

    /**
     * @return Galaxy
     */
    public function getGalaxy(): Galaxy
    {
        return $this->galaxy;
    }

    /**
     * @param Galaxy $galaxy
     */
    public function setGalaxy(Galaxy $galaxy)
    {
        $this->galaxy = $galaxy;
    }

    /**
     * @return Planet[]|Collection
     */
    public function getNearbyPlanets(): Collection
    {
        return $this->nearbyPlanets;
    }

    /**
     * @param Planet[]|Collection $nearbyPlanets
     */
    public function setNearbyPlanets(Collection $nearbyPlanets)
    {
        $this->nearbyPlanets = $nearbyPlanets;
    }


}