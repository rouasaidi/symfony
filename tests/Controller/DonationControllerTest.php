<?php

namespace App\Test\Controller;

use App\Entity\Donation;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DonationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private DonationRepository $repository;
    private string $path = '/donation/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Donation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Donation index');

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
            'donation[name]' => 'Testing',
            'donation[description]' => 'Testing',
            'donation[category]' => 'Testing',
            'donation[quantity]' => 'Testing',
            'donation[date_don]' => 'Testing',
            'donation[status]' => 'Testing',
            'donation[image]' => 'Testing',
            'donation[user]' => 'Testing',
            'donation[panier]' => 'Testing',
        ]);

        self::assertResponseRedirects('/donation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Donation();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCategory('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setDate_don('My Title');
        $fixture->setStatus('My Title');
        $fixture->setImage('My Title');
        $fixture->setUser('My Title');
        $fixture->setPanier('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Donation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Donation();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCategory('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setDate_don('My Title');
        $fixture->setStatus('My Title');
        $fixture->setImage('My Title');
        $fixture->setUser('My Title');
        $fixture->setPanier('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'donation[name]' => 'Something New',
            'donation[description]' => 'Something New',
            'donation[category]' => 'Something New',
            'donation[quantity]' => 'Something New',
            'donation[date_don]' => 'Something New',
            'donation[status]' => 'Something New',
            'donation[image]' => 'Something New',
            'donation[user]' => 'Something New',
            'donation[panier]' => 'Something New',
        ]);

        self::assertResponseRedirects('/donation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getDate_don());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getPanier());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Donation();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCategory('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setDate_don('My Title');
        $fixture->setStatus('My Title');
        $fixture->setImage('My Title');
        $fixture->setUser('My Title');
        $fixture->setPanier('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/donation/');
    }
}
