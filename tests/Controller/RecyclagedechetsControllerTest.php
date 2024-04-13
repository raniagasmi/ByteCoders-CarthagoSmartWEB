<?php

namespace App\Test\Controller;

use App\Entity\Recyclagedechets;
use App\Repository\RecyclagedechetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecyclagedechetsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RecyclagedechetsRepository $repository;
    private string $path = '/recyclagedechets/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Recyclagedechets::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recyclagedechet index');

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
            'recyclagedechet[pointrecyclage]' => 'Testing',
            'recyclagedechet[id]' => 'Testing',
        ]);

        self::assertResponseRedirects('/recyclagedechets/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Recyclagedechets();
        $fixture->setPointrecyclage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recyclagedechet');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Recyclagedechets();
        $fixture->setPointrecyclage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'recyclagedechet[pointrecyclage]' => 'Something New',
            'recyclagedechet[id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/recyclagedechets/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPointrecyclage());
        self::assertSame('Something New', $fixture[0]->getId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Recyclagedechets();
        $fixture->setPointrecyclage('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/recyclagedechets/');
    }
}
