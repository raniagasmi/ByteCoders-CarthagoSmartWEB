<?php

namespace App\Test\Controller;

use App\Entity\Collectdechets;
use App\Repository\CollectdechetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CollectdechetsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CollectdechetsRepository $repository;
    private string $path = '/collectdechets/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Collectdechets::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Collectdechet index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'collectdechet[pointramassage]' => 'Testing',
            'collectdechet[dateramassage]' => 'Testing',
            'collectdechet[id]' => 'Testing',
        ]);

        self::assertResponseRedirects('/collectdechets/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Collectdechets();
        $fixture->setPointramassage('My Title');
        $fixture->setDateramassage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Collectdechet');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Collectdechets();
        $fixture->setPointramassage('My Title');
        $fixture->setDateramassage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'collectdechet[pointramassage]' => 'Something New',
            'collectdechet[dateramassage]' => 'Something New',
            'collectdechet[id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/collectdechets/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPointramassage());
        self::assertSame('Something New', $fixture[0]->getDateramassage());
        self::assertSame('Something New', $fixture[0]->getId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Collectdechets();
        $fixture->setPointramassage('My Title');
        $fixture->setDateramassage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/collectdechets/');
    }
}
