<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Documentperso
 *
 * @ORM\Table(name="documentperso", indexes={@ORM\Index(name="FK_CLASSER", columns={"ID_CATEGORIE"})})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Documentperso
{

    /**
     * @var int
     *
     * @ORM\Column(name="ID_DOCUMENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="INTITULE_DOCUMENT", type="string", length=100, nullable=false)
     */
    private $intituleDocument;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_DE_PARUTION", type="datetime", length=20, nullable=false)
     */
    private $dateDeParution;

    /**
     * @var string

     * @ORM\Column(name="CHEMIN_ABSOLUE", type="string", length=1000, nullable=false)
     */
    private $cheminAbsolue;

    /**
     * @var string
     *
     * @ORM\Column(name="FORMAT", type="string", length=20, nullable=false, options={"fixed"=true})
     */
    private $format;

    /**
     * Many Documents have one (the same) Folder
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="documents")
     * @ORM\JoinColumn(name="ID_CATEGORIE", referencedColumnName="ID_CATEGORIE")
     */
    private $folder;

    /**
     * Get dateDeParution
     *
     * @return Datetime
     */
    public function getDateDeParution(): ?DateTime
    {
        return $this->dateDeParution;
    }


    /**
     * Set dateDeParution
     *
     * @param DateTime $dateDeParution
     *
     * @return Documentperso
     */
    public function setDateDeParution(DateTime $dateDeParution): self
    {
        $this->dateDeParution = $dateDeParution;

        return $this;
    }

    /**
     * Get cheminAbsolue
     *
     * @return String
     */
    public function getCheminAbsolue(): ?string
    {
        return $this->cheminAbsolue;
    }


    /**
     * Set cheminAbsolue
     *
     * @param string $cheminAbsolue
     *
     * @return Documentperso
     */
    public function setCheminAbsolue(string $cheminAbsolue): self
    {
        $this->cheminAbsolue = $this->getUploadRootDir();

        return $this;
    }



    public function getId(): ?int
    {
        return $this->idDocument;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Documentperso
     */
    public function setName($name)
    {
        $this->intituleDocument = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->intituleDocument;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Documentperso
     */
    public function setExtension($extension)
    {
        $this->format = $extension;
        return $this;
    }


    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->format;
    }



    /**
     * Set folder
     *
     * @param \App\Entity\Categorie $folder
     *
     * @return Documentperso
     */
    public function setFolder(\App\Entity\Categorie $folder = null)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return \App\Entity\Categorie $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    private $file;

    // Temporary store the file name
    private $tempFilename;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // Replacing a file ? Check if we already have a file for this entity
        if (null !== $this->format)
        {
            // Save file extension so we can remove it later
            $this->tempFilename = $this->format;

            // Reset values
            $this->format = null;
            $this->intituleDocument = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // If no file is set, do nothing
        if (null === $this->file)
        {
            return;
        }

        // The file name is the entity's ID
        // We also need to store the file extension
        $this->format = $this->file->guessExtension();

        // And we keep the original name
        $this->intituleDocument = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // If no file is set, do nothing
        if (null === $this->file)
        {
            return;
        }

        // A file is present, remove it
        if (null !== $this->tempFilename)
        {
            $oldFile = $this->getUploadRootDir().'/'.$this->intituleDocument.'.'.$this->tempFilename;
            if (file_exists($oldFile))
            {
                unlink($oldFile);
            }
        }

        // Move the file to the upload folder
        $this->file->move(
            $this->getUploadRootDir(),
            $this->intituleDocument.'.'.$this->format
        );
    }


    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // Save the name of the file we would want to remove
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->intituleDocument.'.'.$this->format;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // PostRemove => We no longer have the entity's ID => Use the name we saved
        if (file_exists($this->tempFilename))
        {
            // Remove file
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        // Upload directory
        return 'uploads/documents/';
        // This means /web/uploads/documents/
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        // Image location (PHP)
        return __DIR__.'/../../web/'.$this->getUploadDir();
    }

    public function getUrl()
    {
        return $this->intituleDocument.'.'.$this->format;
    }


}
