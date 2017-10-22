<?php

namespace AppBundle\Controller;

use AppBundle\Entity\neo4j\Galaxy;
use AppBundle\Entity\neo4j\SolarSystem;
use AppBundle\Library\Generators\GalaxyGenerator;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\OGM\Common\Collection;
use GraphAware\Neo4j\OGM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @var Client
     */
    private $neo4jClient;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DefaultController constructor.
     * @param Client $neo4jClient
     * @param EntityManager $entityManager
     */
    public function __construct(Client $neo4jClient, EntityManager $entityManager)
    {
        $this->neo4jClient = $neo4jClient;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @\Symfony\Component\Routing\Annotation\Route(path="/test", name="test")
     */
    public function testAction()
    {

        $galaxy = new Galaxy();
        $galaxy->setName("Andromeda");
        $galaxyGenerator = new GalaxyGenerator();
        $solarSystems = $galaxyGenerator->prepareSolarSystems($galaxy);
        $galaxy->setSolarSystems($solarSystems);


        $repository = $this->entityManager->getRepository(Galaxy::class);


        $this->entityManager->persist($galaxy);
        $this->entityManager->flush();
    }
}
