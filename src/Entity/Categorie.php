<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Categorie
{
    /**
     * Many Documents have one (the same) Folder
     * @ORM\OneToMany(targetEntity="App\Entity\Documentperso", mappedBy="folder", cascade={"persist"}, orphanRemoval=true)
     */
    private $documents;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="ID_CLIENT")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="USER_ID", type="integer", nullable=false)
     */
    private $user_id;


    public function setUserCategorie(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUserCategorie()
    {
        return $this->user;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATEGORIE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_CATEGORIE", type="string", length=20, nullable=false)
     */
    private $nomCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_DE_CATEGORIE", type="string", length=20, nullable=false)
     */
    private $typeDeCategorie;

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getName(): ?string
    {
        return $this->nomCategorie;
    }

    public function setName(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getTypeDeCategorie(): ?string
    {
        return $this->typeDeCategorie;
    }

    public function setTypeDeCategorie(string $typeDeCategorie): self
    {
        $this->typeDeCategorie = $typeDeCategorie;

        return $this;
    }


    /**
     * Add document
     *
     * @param \App\Entity\Documentperso $document
     *
     * @return Categorie
     */
    public function addDocument(\App\Entity\Documentperso $document)
    {
        // Bidirectional Ownership
        $document->setFolder($this);

        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \App\Entity\Documentperso $document
     */
    public function removeDocument(\App\Entity\Documentperso $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }


}
