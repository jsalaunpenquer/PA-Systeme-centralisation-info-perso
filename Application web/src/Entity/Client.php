<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity()
 * @UniqueEntity(fields="adresseMailPerso", message="Cet email existe déjà !")
 */
class Client implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CLIENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClient;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_CLIENT", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Ce champ doit étre rempli")
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM_CLIENT", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ce champ doit étre rempli")
     */
    private $prenomClient;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ADRESSE_CLIENT", type="string", length=20, nullable=true)
     */
    private $adresseClient;

    /**
     * @var string
     *
     * @ORM\Column(name="MDP", type="string", length=100, nullable=false)
     *
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN", type="string", length=12, nullable=false)
     *
     * @Assert\NotBlank(message="Ce champ doit étre rempli")
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NUM_TEL", type="string", length=10, nullable=true)
     * @Assert\NotBlank(message="Ce champ doit étre rempli")
     *
     * @Assert\Length(min="10", max="10", exactMessage = "Numéro de téléphone pas valide")
     */
    private $numTel;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE_MAIL_PERSO", type="string", length=40, nullable=false, unique=true)
     *
     * @Assert\NotBlank(message="Ce champ doit étre rempli")
     *
     * @Assert\Email(
     *     message = "Ce mail '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     *
     */
    private $adresseMailPerso;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE_MAIL_NOTRE_MESSAGERIE", type="string", length=20, nullable=true)
     *
     */
    private $adresseMailNotreMessagerie;

    /**
     * @var string
     *
     * @ORM\Column(name="PLAIN_PASSWORD", type="string", length=100, nullable=false)
     *
     */
    private $plainPassword;

    private $roles = [];


    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }


    public function getPlainPassword()
    {
        return $this->plainPassword;
    }


    public function setPlainPassword($mdp): void
    {
        $this->plainPassword = $mdp;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(?string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $p_mdp): self
    {
        $this->mdp = $p_mdp;

        return $this;
    }


    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(?string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getAdresseMailPerso(): ?string
    {
        return $this->adresseMailPerso;
    }

    public function setAdresseMailPerso(string $adresseMailPerso): self
    {
        $this->adresseMailPerso = $adresseMailPerso;

        return $this;
    }

    public function getAdresseMailNotreMessagerie(): ?string
    {
        return $this->adresseMailNotreMessagerie;
    }

    public function setAdresseMailNotreMessagerie(string $adresseMailNotreMessagerie): self
    {
        $this->adresseMailNotreMessagerie = $adresseMailNotreMessagerie;

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getPassword()
    {
        return $this->mdp;
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->adresseMailPerso;
    }

    public function eraseCredentials()
    {
    }

    public function getUser(){
        return $this;
    }



}
