<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documentperso
 *
 * @ORM\Table(name="documentperso", indexes={@ORM\Index(name="FK_CLASSER", columns={"ID_CATEGORIE"})})
 * @ORM\Entity
 */
class Documentperso
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_DOCUMENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocument;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATEGORIE", type="integer", nullable=false)
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="INTITULE_DOCUMENT", type="string", length=20, nullable=false)
     */
    private $intituleDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="DATE_DE_PARUTION", type="string", length=20, nullable=false)
     */
    private $dateDeParution;

    /**
     * @var string
     *
     * @ORM\Column(name="CHEMIN_ABSOLUE", type="string", length=20, nullable=false)
     */
    private $cheminAbsolue;

    /**
     * @var string
     *
     * @ORM\Column(name="FORMAT", type="string", length=3, nullable=false, options={"fixed"=true})
     */
    private $format;

    public function getIdDocument(): ?int
    {
        return $this->idDocument;
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

    public function getIntituleDocument(): ?string
    {
        return $this->intituleDocument;
    }

    public function setIntituleDocument(string $intituleDocument): self
    {
        $this->intituleDocument = $intituleDocument;

        return $this;
    }

    public function getDateDeParution(): ?string
    {
        return $this->dateDeParution;
    }

    public function setDateDeParution(string $dateDeParution): self
    {
        $this->dateDeParution = $dateDeParution;

        return $this;
    }

    public function getCheminAbsolue(): ?string
    {
        return $this->cheminAbsolue;
    }

    public function setCheminAbsolue(string $cheminAbsolue): self
    {
        $this->cheminAbsolue = $cheminAbsolue;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }


}
