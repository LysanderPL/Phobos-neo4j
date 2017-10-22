<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 22.10.17
 * Time: 16:42
 */

namespace AppBundle\Entity\neo4j;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="SolarSystem")
 */
class SolarSystem
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
     * @var Galaxy
     * @OGM\Relationship(type="SOLAR_SYSTEM_IN_GALAXY", direction="INCOMING", collection=false, mappedBy="solarSystems", targetEntity="Galaxy")
     */
    private $galaxy;
    /**
     * @var Planet[]|Collection
     * @OGM\Relationship(type="PLANET_IN_SOLAR_SYSTEM", direction="OUTGOING", collection=true, mappedBy="solarSystem", targetEntity="Planet")
     */
    private $planets;
    /**
     * @var SolarSystem[]|Collection
     * @OGM\Relationship(type="NEARBY_SOLAR_SYSTEM", direction="BOTH", collection=true, mappedBy="nearbySolarSystems", targetEntity="SolarSystem")
     */
    private $nearbySolarSystems;

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
    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    /**
     * @param Planet[]|Collection $planets
     */
    public function setPlanets(Collection $planets)
    {
        $this->planets = $planets;
    }

    /**
     * @return SolarSystem[]|Collection
     */
    public function getNearbySolarSystems(): Collection
    {
        return $this->nearbySolarSystems;
    }

    /**
     * @param SolarSystem[]|Collection $nearbySolarSystems
     */
    public function setNearbySolarSystems(Collection $nearbySolarSystems)
    {
        $this->nearbySolarSystems = $nearbySolarSystems;
    }

}