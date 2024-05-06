<?php

namespace App\Test\Controller;

use App\Entity\Facture;
use App\Repository\factureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FactureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private factureRepository $repository;
    private string $path = '/facture/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Facture::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Facture index');

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
            'facture[libelle]' => 'Testing',
            'facture[date]' => 'Testing',
            'facture[dateEch]' => 'Testing',
            'facture[montant]' => 'Testing',
            'facture[type]' => 'Testing',
            'facture[estPayee]' => 'Testing',
            'facture[idUser]' => 'Testing',
        ]);

        self::assertResponseRedirects('/facture/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Facture();
        $fixture->setLibelle('My Title');
        $fixture->setDate('My Title');
        $fixture->setDateEch('My Title');
        $fixture->setMontant('My Title');
        $fixture->setType('My Title');
        $fixture->setEstPayee('My Title');
        $fixture->setIdUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Facture');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Facture();
        $fixture->setLibelle('My Title');
        $fixture->setDate('My Title');
        $fixture->setDateEch('My Title');
        $fixture->setMontant('My Title');
        $fixture->setType('My Title');
        $fixture->setEstPayee('My Title');
        $fixture->setIdUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'facture[libelle]' => 'Something New',
            'facture[date]' => 'Something New',
            'facture[dateEch]' => 'Something New',
            'facture[montant]' => 'Something New',
            'facture[type]' => 'Something New',
            'facture[estPayee]' => 'Something New',
            'facture[idUser]' => 'Something New',
        ]);

        self::assertResponseRedirects('/facture/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getDateEch());
        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getEstPayee());
        self::assertSame('Something New', $fixture[0]->getIdUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Facture();
        $fixture->setLibelle('My Title');
        $fixture->setDate('My Title');
        $fixture->setDateEch('My Title');
        $fixture->setMontant('My Title');
        $fixture->setType('My Title');
        $fixture->setEstPayee('My Title');
        $fixture->setIdUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/facture/');
    }
}
