<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="FK_POSSEDER", columns={"ID_CLIENT"}), @ORM\Index(name="FK_ENVOYER", columns={"ID_ENTREPRISE"}), @ORM\Index(name="FK_RANGER", columns={"ID_CATEGORIE"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_FACTURE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATEGORIE", type="integer", nullable=false)
     */
    private $idCategorie;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_CLIENT", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_ENTREPRISE", type="integer", nullable=false)
     */
    private $idEntreprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_RECUE", type="date", nullable=false)
     */
    private $dateRecue;

    /**
     * @var string
     *
     * @ORM\Column(name="MONTANT_FACTURE", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $montantFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="CHEMIN_FACTURE", type="string", length=20, nullable=false)
     */
    private $cheminFacture;

    /**
     * @var bool
     *
     * @ORM\Column(name="PAYE", type="boolean", nullable=false)
     */
    private $paye;

    /**
     * @var string
     *
     * @ORM\Column(name="INTITULE_FACTURE", type="string", length=20, nullable=false)
     */
    private $intituleFacture;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdEntreprise(): ?int
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(int $idEntreprise): self
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
    }

    public function getDateRecue(): ?\DateTimeInterface
    {
        return $this->dateRecue;
    }

    public function setDateRecue(\DateTimeInterface $dateRecue): self
    {
        $this->dateRecue = $dateRecue;

        return $this;
    }

    public function getMontantFacture(): ?string
    {
        return $this->montantFacture;
    }

    public function setMontantFacture(string $montantFacture): self
    {
        $this->montantFacture = $montantFacture;

        return $this;
    }

    public function getCheminFacture(): ?string
    {
        return $this->cheminFacture;
    }

    public function setCheminFacture(string $cheminFacture): self
    {
        $this->cheminFacture = $cheminFacture;

        return $this;
    }

    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }

    public function getIntituleFacture(): ?string
    {
        return $this->intituleFacture;
    }

    public function setIntituleFacture(string $intituleFacture): self
    {
        $this->intituleFacture = $intituleFacture;

        return $this;
    }


}
