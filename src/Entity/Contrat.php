<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContratRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints as Assert ;
/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 */
class Contrat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_depart;

    /**
     * @ORM\Column(type="datetime")
      * @Assert\GreaterThan("today")
     */
    private $date_de_retour;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voiture;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

  

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateDeDepart(): ?\DateTimeInterface
    {
        return $this->date_de_depart;
    }

    public function setDateDeDepart(\DateTimeInterface $date_de_depart): self
    {
        $this->date_de_depart = $date_de_depart;

        return $this;
    }

    public function getDateDeRetour(): ?\DateTimeInterface
    {
        return $this->date_de_retour;
    }

    public function setDateDeRetour(\DateTimeInterface $date_de_retour): self
    {
        $this->date_de_retour = $date_de_retour;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }


}
