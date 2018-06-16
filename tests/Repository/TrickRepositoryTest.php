<?php
namespace App\Tests\Repository;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TrickRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindNbPages15PerPage()
    {
        $nbPages = $this->entityManager
            ->getRepository(Trick::class)
            ->findNbPages(15);
        ;

        $this->assertSame(2, $nbPages);
    }

    public function testFindNbPages5PerPage()
    {
        $nbPages = $this->entityManager
            ->getRepository(Trick::class)
            ->findNbPages(5);
        ;

        $this->assertSame(4, $nbPages);
    }

    public function testNbTrickFindPageNoOffset()
    {
        $tricks = $this->entityManager
          ->getRepository(Trick::class)
          ->findAPage(0, 15);
        ;

        $this->assertCount(15, $tricks);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
