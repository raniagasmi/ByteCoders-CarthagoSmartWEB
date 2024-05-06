<?php

namespace App\Test\Controller;

use App\Entity\Paiement;
use App\Repository\paiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaiementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private paiementRepository $repository;
    private string $path = '/paiement/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Paiement::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Paiement index');

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
            'paiement[montant]' => 'Testing',
            'paiement[modePaiement]' => 'Testing',
            'paiement[idFacture]' => 'Testing',
            'paiement[id]' => 'Testing',
        ]);

        self::assertResponseRedirects('/paiement/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Paiement();
        $fixture->setMontant('My Title');
        $fixture->setModePaiement('My Title');
        $fixture->setIdFacture('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Paiement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Paiement();
        $fixture->setMontant('My Title');
        $fixture->setModePaiement('My Title');
        $fixture->setIdFacture('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'paiement[montant]' => 'Something New',
            'paiement[modePaiement]' => 'Something New',
            'paiement[idFacture]' => 'Something New',
            'paiement[id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/paiement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getModePaiement());
        self::assertSame('Something New', $fixture[0]->getIdFacture());
        self::assertSame('Something New', $fixture[0]->getId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Paiement();
        $fixture->setMontant('My Title');
        $fixture->setModePaiement('My Title');
        $fixture->setIdFacture('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/paiement/');
    }
}
